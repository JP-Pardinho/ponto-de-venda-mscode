<?php

namespace App\Controller\Produto;

use App\Entity\Produto;
use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SalvarProdutoController extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository,
        private CategoriaRepository $categoriaRepository
    ) {   
    }

    #[Route('/produtos/salvar', name: 'salvar_produto_show', methods:'GET')]
    public function show(): Response
    {
        return $this->render('produto/new.html.twig', [
            'categorias' => $this->categoriaRepository->findAll(),
        ]);
    }


    #[Route('/produtos/salvar', name: 'salvar_produto', methods:'POST')]
    public function new(Request $request): Response
    {
        $nomeProduto = $request->request->get('nome');

        if (strlen($nomeProduto) > 100) {
            $this->addFlash('danger', 'O nome do produto deve ter no máximo 100 caracteres!');
            return $this->redirectToRoute('salvar_produto_show');
        }

        $produtoExistente = $this->produtoRepository->findOneBy(['nome' => $nomeProduto]);
        if ($produtoExistente) {
            $this->addFlash('danger', 'Esse nome já está cadastrado a outro produto!');
            return $this->redirectToRoute('listar_produtos');
        }

        if ($request->get('categoriaId') == null) {
            $this->addFlash('danger', 'Por favor, selecione uma categoria antes de salvar o produto!');
            return $this->redirectToRoute('salvar_produto_show');
        }

        if ($request->get('valor') <= 0) {
            $this->addFlash('danger', 'Produto com valor inválido. O valor do produto não pode ser menor ou igual a zero.');
            return $this->redirectToRoute('salvar_produto_show');
        }

        if ($request->get('quantidade') <= 0) {
            $this->addFlash('danger', 'Produto com quantidade inválida. A quantidade do produto não pode ser menor ou igual a zero.');
            return $this->redirectToRoute('salvar_produto_show');
        }

        $categoria = $this->categoriaRepository->find($request->request->get('categoriaId'));

        $produto = new Produto();
        $produto->setNome($nomeProduto);
        $produto->setDescricao($request->request->get('descricao'));
        $produto->setCategoria($categoria);
        $produto->setQuantidadeInicial($request->request->get('quantidade'));
        $produto->setQuantidadeEstoque($request->request->get('quantidade'));
        $produto->setValor($request->request->get('valor'));
        $produto->setDataCadastro(new \DateTime());
        $produto->setAtivo(true);

        $this->produtoRepository->salvar($produto);

        return $this->redirectToRoute('listar_produtos');
    }
}
