<?php

namespace App\Controller\Produto\Remover;

use App\Entity\Produto;
use App\Service\Produto\ProdutoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;


final class Controller extends AbstractController
{
    public function __construct(
        private ProdutoService $produtoService
    ) {     
    }

    #[Route('/produtos/remover/{produto}', name: 'remover_produto', methods:'POST')]
    public function remover(Produto $produto): Response
    {    
        try {
            $this->produtoService->removerOuInativar($produto);
            $this->addFlash('success', 'Produto excluído.');
        } catch (Throwable $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->redirectToRoute('listar_produtos');
    }
}
