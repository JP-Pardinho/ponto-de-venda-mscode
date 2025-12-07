<?php

namespace App\Controller\PDV\Concluir;

use App\Service\Venda\VendaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private VendaService $vendaService
    ) {
    }

    #[Route('/pdv/{id}/concluir', name: 'pdv_concluir', methods: ['POST'])]
    public function concluir(int $id): Response
    {
        try {
            $this->vendaService->concluirVenda($id);
            return $this->redirectToRoute('venda_recibo', ['id' => $id]);
        } catch (\Exception $e) {
            $this->addFlash('danger', $e->getMessage());
            return $this->redirectToRoute('pdv_pagamento', ['id' => $id]);
        }
    }
}
