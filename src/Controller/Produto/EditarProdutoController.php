<?php

namespace App\Controller\Produto;

use App\Entity\Produto;
use App\Form\ProdutoType;
use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EditarProdutoController extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository,
        private CategoriaRepository $categoriaRepository
    ) {        
    }

        #[Route('/produtos/{produto}/editar}', name: 'editar_produto', methods:['GET', 'POST'])]
    public function editar(Produto $produto, Request $request): Response
    {
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->produtoRepository->salvar($produto);

            $this->addFlash('success', 'Produto atualizado com sucesso!');
            return $this->redirectToRoute('listar_produtos');
        }

        return $this->render('produto/edit.html.twig', [
            'produto' => $produto,
            'form' => $form,
        ]);
    }

   
}
