<?php

namespace App\Controller\Venda\Recibo;

use App\Entity\Venda;
use App\Repository\VendaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private VendaRepository $vendaRepository,
    ) {
    }

    #[Route('/vendas/{id}/recibo', name: 'venda_recibo', methods:'GET')]
    public function recibo(int $id): Response
    {
        $venda = $this->vendaRepository->find($id);

        if (!$venda) $this->addFlash('danger', 'Venda não encontrada');

        if ($venda->getStatus() === Venda::STATUS_ABERTA) {
            $this->addFlash('warning', 'Esta venda ainda não foi finalizada.');
            return $this->redirectToRoute('listar_vendas');
        }

        return $this->render('venda/recibo.html.twig', [
            'venda' => $venda,
        ]);
    }
}
