<?php

namespace App\Controller\Produto\Salvar;

use App\Entity\Produto;
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

    #[Route('/produtos/salvar', name: 'salvar_produto', methods:['GET', 'POST'])]
    public function salvar(Request $request): Response
    {
        $produto = new Produto();
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->produtoService->criar($produto);

            $this->addFlash('success', 'Produto cadastrado com sucesso!');
            return $this->redirectToRoute('listar_produtos');
        }

        return $this->render('usuario/new.html.twig', [
            'form' => $form,
        ]);
    }
}
