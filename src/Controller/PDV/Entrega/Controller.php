<?php

namespace App\Controller\PDV\Entrega;

use App\Entity\Venda;
use App\Form\DadosVendaType;
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
        private VendaService $vendaService,
    ) {
    }

    #[Route('/pdv/{id}/dados-entrega', name: 'pdv_dados_entrega', methods: ['GET', 'POST'])]
    public function __invoke(int $id, Request $request): Response
    {
        $venda = $this->vendaRepository->find($id);

        if (!$venda || $venda->getStatus() !== Venda::STATUS_ABERTA) {
            return $this->redirectToRoute('app');
        }

        if ($venda->getVendaItems()->isEmpty()) {
            $this->addFlash('danger', 'Não é possível finalizar uma venda sem produtos!');
            return $this->redirectToRoute('pdv_pdv', ['id' => $id]);
        }

        if (!$request->isMethod('POST') && !$venda->getPagamentos()->isEmpty()) {
            $this->vendaService->limparPagamentos($id);
        }

        $form = $this->createForm(DadosVendaType::class, $venda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->vendaService->salvarDadosEntrega($venda);
                return $this->redirectToRoute('pdv_pagamento', ['id' => $id]);

            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());
                return $this->redirectToRoute('pdv_dados_entrega', ['id' => $id]);
            }
        }

        return $this->render('pdv/entrega.html.twig', [
            'venda' => $venda,
            'form' => $form,
        ]);
    }
}
