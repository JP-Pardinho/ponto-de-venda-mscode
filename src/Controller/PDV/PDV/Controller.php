<?php

namespace App\Controller\PDV\PDV;

use App\Form\VendaItemType;
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

    #[Route('/pdv/{id}/pdv', name: 'pdv_pdv', methods: ['GET'])]
    public function __invoke(int $id): Response
    {
        $venda = $this->vendaRepository->find($id);

        if (!$venda) {
            $this->addFlash('danger', 'Venda não encontrada');
        }

        $form = $this->createForm(VendaItemType::class);

        return $this->render('pdv/pdv.html.twig', [
            'venda' => $venda,
            'form' => $form,
        ]);
    }
}