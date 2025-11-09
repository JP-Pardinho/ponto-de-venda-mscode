<?php

namespace App\Controller\Categoria;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SalvarCategoriaController extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository
    ) {  
    }

    #[Route('/categorias/salvar', name: 'cadastrar_categoria_show', methods:'GET')]
    public function show(): Response
    {
        return $this->render('categoria/new.html.twig');
    }

    #[Route('/categorias/salvar', name: 'cadastrar_categoria', methods:'POST')]
    public function new(Request $request): Response
    {
        $nomeCategoria = $request->request->get('nome');

        if (strlen($nomeCategoria) > 50) {
            $this->addFlash('danger', 'O nome da categoria tem que ter no máximo 50 caracteres!');
            return $this->redirectToRoute('cadastrar_categoria_show');
        }

        $categoriaExistente = $this->categoriaRepository->findOneBy(['nome' => $nomeCategoria]);
        if ($categoriaExistente) {
            $this->addFlash('danger', 'Já existe uma categoria cadastrada com esse nome!');
            return $this->redirectToRoute('cadastrar_categoria_show');
        }

        $categoria = new Categoria();
        $categoria->setNome($nomeCategoria);

        $this->categoriaRepository->salvar($categoria);
        $this->addFlash('success', 'Categoria cadastrada com sucesso!');

        return $this->redirectToRoute('listar_categorias');
    }
}
