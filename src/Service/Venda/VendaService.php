<?php

namespace App\Service\Venda;

use App\Entity\PagamentoVenda;
use App\Entity\Venda;
use App\Entity\VendaItem;
use App\Exception\Produto\NovoEstoqueException;
use App\Exception\Produto\ProdutoEstoqueIndisponivelException;
use App\Exception\Produto\ProdutoInativoException;
use App\Exception\Produto\ProdutoNaoEncontradoException;
use App\Exception\Usuario\UsuarioNaoEncontradoException;
use App\Exception\Venda\DescontoInvalidoException;
use App\Exception\Venda\ItemNaoEncontradoException;
use App\Exception\Venda\PagamentoInsuficienteException;
use App\Exception\Venda\PorcentagemDescontoInvalidoException;
use App\Exception\Venda\RemoverItemVendaFechadaException;
use App\Exception\Venda\ValorDescontoInvalidoException;
use App\Exception\Venda\ValorDescontoNegativoException;
use App\Exception\Venda\VendaFechadaException;
use App\Exception\Venda\VendaNaoEncontradaException;
use App\Repository\ProdutoRepository;
use App\Repository\VendaRepository;
use App\Repository\UsuarioRepository;
use App\Repository\VendaItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class VendaService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ProdutoRepository $produtoRepository,
        private VendaRepository $vendaRepository,
        private UsuarioRepository $usuarioRepository,
        private VendaItemRepository $vendaItemRepository,
        private Security $security
    ) {
    }

    public function iniciaVenda(int $usuarioId): Venda
    {
        $usuario = $this->usuarioRepository->find($usuarioId);
        if (!$usuario) {
            throw new UsuarioNaoEncontradoException();
        }

        $venda = new Venda();
        $venda->setUsuario($usuario);
        $venda->setValorTotal(0.0);
        $this->vendaRepository->salvar($venda);

        return $venda;
    }

    public function adicionarItem (int $vendaId, int $produtoId, int $quantidade): Venda
    {
        $venda = $this->vendaRepository->find($vendaId);
        $produto = $this->produtoRepository->find($produtoId);

        if (!$venda) throw new VendaNaoEncontradaException();
        if (!$produto) throw new ProdutoNaoEncontradoException();
        if (!$produto->isAtivo()) throw new ProdutoInativoException();

        if ($venda->getStatus() !== Venda::STATUS_ABERTA) {
            throw new VendaFechadaException();
        }

        if ($produto->getQuantidadeEstoque() < $quantidade) {
            throw new ProdutoEstoqueIndisponivelException();
        }

        $itemExistente = null;

        foreach ($venda->getVendaItems() as $item) {
            if ($item->getProduto()->getId() === $produto->getId()) {
                $itemExistente = $item;
                break; 
            }
        }

        if ($itemExistente) {            
            $novaQuantidadeTotal = $itemExistente->getQuantidade() + $quantidade;

            if ($produto->getQuantidadeEstoque() < $novaQuantidadeTotal) {
                throw new ProdutoEstoqueIndisponivelException();
            }

            $itemExistente->setQuantidade($novaQuantidadeTotal);
        } else {
            if ($produto->getQuantidadeEstoque() < $quantidade) {
                throw new ProdutoEstoqueIndisponivelException();
            }

            $novoItem = new VendaItem();
            $novoItem->setProduto($produto);
            $novoItem->setQuantidade($quantidade);
            $novoItem->setValorAtualProduto($produto->getValor());
            $novoItem->setVenda($venda);
            $venda->addVendaItem($novoItem);
        }
        $this->atualizarTotalVenda($venda);
        $this->entityManager->flush();

        return $venda;
    }

    public function removerItem(int $vendaItemId): void
    {
        $item = $this->vendaItemRepository->find($vendaItemId);

        if (!$item) throw new ItemNaoEncontradoException();
        
        $venda = $item->getVenda();
        if ($venda->getStatus() !== Venda::STATUS_ABERTA) {
            throw new RemoverItemVendaFechadaException();
        }

        $venda->removeVendaItem($item);
        $this->entityManager->remove($item);
        $this->atualizarTotalVenda($venda);
        $this->entityManager->flush();
    }

    private function atualizarTotalVenda(Venda $venda): void
    {
        $total = 0.0;
        foreach ($venda->getVendaItems() as $item) {
            $total += $item->getValorAtualProduto() * $item->getQuantidade(); 
        }

        $venda->setValorTotal($total);
    }

    public function aplicarDesconto(int $vendaId, ?float $valorDesconto = 0.0): void
    {
        $venda = $this->vendaRepository->find($vendaId);

        if (!$venda) throw new VendaNaoEncontradaException();
        
        if ($valorDesconto > $venda->getValorTotal()) throw new ValorDescontoInvalidoException();
        

        $limiteOperador = $venda->getValorTotal() * 0.10;

        if ($this->security->isGranted('ROLE_USER') || $this->security->isGranted('')  && !$this->security->isGranted('ROLE_ADMIN')) {
            if ($valorDesconto > $limiteOperador) 
                throw new PorcentagemDescontoInvalidoException();
        }

        if ($valorDesconto < 0) throw new ValorDescontoNegativoException();

        $venda->setValorDesconto($valorDesconto);
        $this->entityManager->flush();
    }

    public function adicionarPagamento(int $vendaId, string $tipo, float $valor, int $parcelas = 1): void
    {
        $venda = $this->vendaRepository->find($vendaId);

        if (!$venda) throw new VendaNaoEncontradaException();
        if ($venda->getStatus() !== Venda::STATUS_ABERTA) throw new VendaFechadaException();

        $totalVenda = $venda->getValorTotal() - ($venda->getValorDesconto() ?? 0);
        $totalPago = 0.0;
        foreach ($venda->getPagamentos() as $p) {
            $totalPago += $p->getValor();
        }

        $restante = round($totalVenda - $totalPago, 2);

        if ($tipo !== 'DINHEIRO' && $valor > ($restante + 0.01)) {
            throw new \Exception(sprintf(
                "Pagamento em %s não pode ser maior que o valor restante (R$ %s).", 
                $tipo, 
                number_format($restante, 2, ',', '.')
            ));
        }

        $pagamento = new PagamentoVenda();
        $pagamento->setTipoPagamento($tipo);
        $pagamento->setValor($valor);
        $pagamento->setParcelas($tipo === 'CREDITO' ? $parcelas : 1);

        $venda->addPagamento($pagamento);
        $this->entityManager->flush();
    }

    public function concluirVenda(int $vendaId): Venda
    {
        $venda = $this->vendaRepository->find($vendaId);

        if (!$venda) throw new VendaNaoEncontradaException();
        
        if ($venda->getStatus() !== Venda::STATUS_ABERTA) {
            throw new VendaFechadaException();
        }

        $totalVenda = $venda->getValorTotal() - ($venda->getValorDesconto() ?? 0);
        $totalPago = 0.0;
        
        foreach ($venda->getPagamentos() as $pag) {
            $totalPago += $pag->getValor();
        }

        if ($totalPago < ($totalVenda - 0.01)) {
            throw new PagamentoInsuficienteException();
        }

        $troco = max(0, $totalPago - $totalVenda);
        $venda->setTroco($troco);

        foreach ($venda->getVendaItems() as $item) {
            $produto = $item->getProduto();
            $novoEstoque = $produto->getQuantidadeEstoque() - $item->getQuantidade();

            if ($novoEstoque < 0) {
                throw new NovoEstoqueException($produto->getNome());
            }
            $produto->setQuantidadeEstoque($novoEstoque);
        }

        $venda->setDataVenda(new \DateTime());
        $venda->setStatus(Venda::STATUS_FINALIZADA);
        $this->entityManager->flush();

        return $venda;
    }

    public function cancelarVenda(Venda $venda): void
    {
        if (!$venda) throw new VendaNaoEncontradaException();

        if ($venda->getStatus() === Venda::STATUS_CANCELADA) throw new VendaFechadaException();
        
        if ($venda->getStatus() === Venda::STATUS_FINALIZADA) {
            foreach ($venda->getVendaItems() as $item) {
                $produto = $item->getProduto();
                $novaQuantidade = $produto->getQuantidadeEstoque() + $item->getQuantidade();
                $produto->setQuantidadeEstoque($novaQuantidade);
            }
        }

        $venda->setStatus(Venda::STATUS_CANCELADA);
        $this->entityManager->flush();
    }

    public function limparPagamentos(int $vendaId): void
    {
        $venda = $this->vendaRepository->find($vendaId);
        
        if (!$venda) return;

        foreach ($venda->getPagamentos() as $pagamento) {
            $venda->removePagamento($pagamento);
        }

        $this->entityManager->flush();
    }

    public function salvarDadosEntrega(Venda $venda): void
    {
        if ($venda->getTipoEntrega() === Venda::TIPO_RETIRADA) {
            $venda->setEnderecoEntrega(null);
        }

        if ($venda->getTipoEntrega() === Venda::TIPO_ENTREGA && $venda->getCliente() === null) {
            throw new \Exception('Para realizar uma entrega, é necessário identificar o cliente.');
        }

        if ($venda->getTipoEntrega() === Venda::TIPO_ENTREGA && empty($venda->getEnderecoEntrega())) {
            throw new \Exception('Preencha o campo de endereço para continuar.');
        }

        $this->entityManager->flush();
    }
}