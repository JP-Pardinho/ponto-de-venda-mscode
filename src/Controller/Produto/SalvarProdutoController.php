<?php

namespace App\Controller\Produto;

use App\Entity\Produto;
use App\Form\ProductType;
use App\Form\ProdutoType;
use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SalvarProdutoController extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository
    ) {   
    }

    #[Route('/produtos/salvar', name: 'salvar_produto', methods:['GET', 'POST'])]
    public function salvar(Request $request): Response
    {
        $produto = new Produto();
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produto->setQuantidadeInicial($produto->getQuantidadeEstoque());
            $produto->setDataCadastro(new \DateTime());
            $produto->setAtivo(true);

            $this->produtoRepository->salvar($produto);

            $this->addFlash('success', 'Produto cadastrado com sucesso!');
            return $this->redirectToRoute('listar_produtos');
        }

        return $this->render('produto/new.html.twig', [
            'form' => $form,
        ]);
    }
}
