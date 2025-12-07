<?php

namespace App\Controller\Produto\Reativar;

use App\Entity\Produto;
    use App\Service\Produto\ProdutoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private ProdutoService $produtoService
    ) {
    }

    #[Route('/produtos/reativar/{produto}', name: 'reativar_produto', methods:'POST')]
    public function remover(Produto $produto): Response
    {
        $this->produtoService->reativar($produto);
        $this->addFlash('success', 'Produto reativado com sucesso!');

        return $this->redirectToRoute('listar_produtos');
    }
}
