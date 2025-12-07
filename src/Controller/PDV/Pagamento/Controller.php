<?php

namespace App\Controller\PDV\Pagamento;

use App\Entity\PagamentoVenda;
use App\Entity\Venda;
use App\Form\PagamentoVendaType;
use App\Repository\VendaRepository;
use App\Service\Venda\VendaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private VendaRepository $vendaRepository,
        private VendaService $vendaService
    ) {
    }

    #[Route('/pdv/{id}/pagamento', name: 'pdv_pagamento', methods:['GET', 'POST'])]
    public function pagamento(int $id, Request $request): Response
    {
        $venda = $this->vendaRepository->find($id);

        if (!$venda || $venda->getStatus() !== Venda::STATUS_ABERTA) {
            return $this->redirectToRoute('app');
        } 

        $totalVenda = $venda->getValorTotal() - $venda->getValorDesconto();
        $totalPago = 0.0;
        foreach ($venda->getPagamentos() as $p) {
            $totalPago += $p->getValor();
        }
        $restante = max(0, $totalVenda - $totalPago);
        $troco = max(0, $totalPago - $totalVenda);

        $pagamento = new PagamentoVenda();
    
        $pagamento->setValor($restante);
        $pagamento->setParcelas(1);

        $form = $this->createForm(PagamentoVendaType::class, $pagamento);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PagamentoVenda $dadosPagamento */
            $dadosPagamento = $form->getData(); 

            $tipo = $dadosPagamento->getTipoPagamento();
            $valor = $dadosPagamento->getValor();
            $parcelasDigitadas = $dadosPagamento->getParcelas();

            if ($tipo !== 'CREDITO' && $parcelasDigitadas > 1) {
                $parcelas = 1;
                $this->addFlash('warning', "O pagamento foi registrado, mas alterado para 1x pois $tipo não permite parcelamento.");
            } elseif ($tipo === 'CREDITO' && $parcelasDigitadas > 12) {
                $parcelas = 12;
                $this->addFlash('warning', 'O pagamento foi ajustado para o limite de 12 parcelas.');
            } elseif ($tipo === 'CREDITO' && $parcelasDigitadas < 1) {
                $parcelas = 1;
                $this->addFlash('warning', 'O pagamento foi ajustado para o limite de 1 parcela');
            } else {
                $parcelas = $parcelasDigitadas;
                $this->addFlash('success', 'Pagamento registrado com sucesso!');
            }

            try {
                $this->vendaService->adicionarPagamento($id, $tipo, $valor, $parcelas);
            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());
            }

            return $this->redirectToRoute('pdv_pagamento', [
                'id' => $id,
            ]);
        }

        return $this->render('pdv/pagamento.html.twig', [
            'venda' => $venda,
            'form' => $form,
            'totalPago' => $totalPago,
            'restante' => $restante,
            'troco' => $troco
        ]);
    }
}
