<?php

namespace App\Controller\Venda\Listar;

use App\Repository\VendaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private VendaRepository $vendaRepository
    ) {
    }

    #[Route('/vendas', name: 'listar_vendas')]
    public function show(): Response
    {
        // $vendas = $this->vendaRepository->findAll();
        // dd($vendas);
        return $this->render('venda/index.html.twig', [
            'vendas' => $this->vendaRepository->findBy([], [
                'dataVenda' => 'DESC'
            ]),
        ]);
    }
}
