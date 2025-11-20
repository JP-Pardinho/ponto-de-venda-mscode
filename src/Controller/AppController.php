<?php

namespace App\Controller;

use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AppController extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository,
        private CategoriaRepository $categoriaRepository
    ) {
    }

    #[Route('/app', name: 'app')]
    public function index(): Response
    {
        $categorias = $this->categoriaRepository->findAll();
        $produtos = $this->produtoRepository->findAll();

        return $this->render('/app/index.html.twig', [
            'categorias' => $categorias,
            'produtos' => $produtos,
        ]);
    }

    #[Route('/sobre', name: 'app_sobre')]
    public function sobre(): Response
    {
        return $this->render('app/sobre.html.twig');
    }
}
