<?php

namespace App\Controller\Produto\Listar;

use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository,
        private CategoriaRepository $categoriaRepository
    ) {  
    }

    #[Route('/produtos', name: 'listar_produtos')]
    public function show(Request $request): Response
    {

        $q = $request->query->get('q', '');

        $produtos = $this->produtoRepository->buscarPorNome($q);

        return $this->render('produto/index.html.twig', [
            'produtos' =>  $produtos,
            'q'        => $q,
        ]);
    }
}
