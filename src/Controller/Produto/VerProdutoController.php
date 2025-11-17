<?php

namespace App\Controller\Produto;

use App\Entity\Produto;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VerProdutoController extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository
    ) {   
    }

    #[Route('/produtos/{produto}', name: 'ver_produto', methods:'GET')]
    public function read(Produto $produto): Response
    {
        if (!$produto) {
            $this->addFlash('danger', 'Não foi possível encontrar o produto selecionado!');
            return $this->redirectToRoute('listar_produtos');
        }
        
        return $this->render('produto/read.html.twig', [
            'produto' => $produto,
        ]);
    }
}
