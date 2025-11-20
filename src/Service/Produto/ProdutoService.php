<?php 

namespace App\Service\Produto;

use App\Entity\Produto;
use App\Exception\Produto\ProdutoJaVendidoException;
use App\Repository\ProdutoRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProdutoService 
{
    public function __construct(
        private ProdutoRepository $produtoRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function criar(Produto $produto): void 
    {
        $produto->setQuantidadeInicial($produto->getQuantidadeEstoque());
        $produto->setDataCadastro(new \DateTime());
        $produto->setAtivo(true);

        $this->produtoRepository->salvar($produto);
    }

    public function editar(Produto $produto): void
    {
        $this->entityManager->flush();
    }

    public function removerOuInativar(Produto $produto): void 
    {
        if (! $produto->getVendaItems()->isEmpty()) {
            $produto->setAtivo(false);
            $this->entityManager->flush();
            
            throw new ProdutoJaVendidoException();      
        }

        $this->produtoRepository->remover($produto);
    }

}