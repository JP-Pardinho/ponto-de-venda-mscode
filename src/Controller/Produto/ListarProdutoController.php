<?php

namespace App\Controller\Produto;

use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListarProdutoController extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository,
        private CategoriaRepository $categoriaRepository
    ) {  
    }

    #[Route('/produtos', name: 'listar_produtos')]
    public function show(): Response
    {
        return $this->render('produto/index.html.twig', [
            'produtos' => $this->produtoRepository->findAllWithCategory(),
        ]);
    }
}
