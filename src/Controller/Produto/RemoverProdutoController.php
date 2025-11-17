<?php

namespace App\Controller\Produto;

use App\Entity\Produto;
use App\Repository\ProdutoRepository;
use App\Service\Produto\VerificaProdutoVendidoException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;


final class RemoverProdutoController extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository
    ) {     
    }

    #[Route('/produtos/remover/{produto}', name: 'remover_produto', methods:'POST')]
    public function remover(Produto $produto): Response
    {    
        try {
            if (!$produto->getVendaItems()->isEmpty()) {
                throw new VerificaProdutoVendidoException(); 
            }
            $this->produtoRepository->remover($produto);
        } catch (Throwable $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->redirectToRoute('listar_produtos');
    }
}
