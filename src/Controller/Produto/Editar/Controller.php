<?php

namespace App\Controller\Produto\Editar;

use App\Entity\Produto;
use App\Form\AdicionarEstoqueType;
use App\Form\ProdutoType;
use App\Service\Produto\ProdutoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private ProdutoService $produtoService
    ) {        
    }

    #[Route('/produtos/{produto}/editar}', name: 'editar_produto', methods:['GET', 'POST'])]
    public function editar(Produto $produto, Request $request): Response
    {
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->produtoService->editar($produto);
            $this->addFlash('success', 'Produto atualizado com sucesso!');
            
            return $this->redirectToRoute('listar_produtos');
        }

        return $this->render('produto/edit.html.twig', [
            'produto' => $produto,
            'form' => $form,
        ]);
    }

    #[Route('/produtos/{produto}/estoque}', name: 'editar_estoque_produto', methods:['GET', 'POST'])]
    public function editarQuantidade(Produto $produto, Request $request): Response
    {
        $form = $this->createForm(AdicionarEstoqueType::class, null, [
            'estoque_atual' => $produto->getQuantidadeEstoque(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quantidadeAdicional = $form->get('quantidadeAdicional')->getData();

            try {
                $this->produtoService->editarQuantidade($produto, $quantidadeAdicional);
                
                $this->addFlash('success', "Estoque atualizado! Foram adicionadas {$quantidadeAdicional} unidades.");
                return $this->redirectToRoute('listar_produtos');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erro ao atualizar estoque: ' . $e->getMessage());
            }
        }

        return $this->render('produto/stock.html.twig', [
            'produto' => $produto,
            'form' => $form,
        ]);
    }
   
}
