<?php

namespace App\Controller\Categoria;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EditarCategoriaController extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository
    ) {   
    }

    #[Route('/categoria/{categoria}/editar', name: 'editar_categoria_show', methods:'GET')]
    public function show(Categoria $categoria): Response
    {
        if (!$categoria) {
            $this->addFlash('danger', 'Não foi possível encontrar a categoria!');
            return $this->redirectToRoute('listar_categorias');
        }

        return $this->render('categoria/edit.html.twig', [
            'categoria' => $categoria
        ]);
    }

    #[Route('/categoria/{categoria}/editar', name: 'editar_categoria', methods:'POST')]
    public function editar(Categoria $categoria, Request $request): Response
    {
        if (!$categoria) {
            $this->addFlash('danger', 'Não foi possível encontrar a categoria!');
            return $this->redirectToRoute('listar_categorias');
        }
        
        $nomeCategoria = $request->request->get('nome');

        if (strlen($nomeCategoria) > 50) {
            $this->addFlash('danger', 'O nome da categoria tem que ter no máximo 50 caracteres!');
            return $this->redirectToRoute('listar_categorias');
        }

        $categoriaExistente = $this->categoriaRepository->findOneBy(['nome' => $nomeCategoria]);
        if ($categoriaExistente) {
            $this->addFlash('danger', 'Já existe uma categoria cadastrada com esse nome!');
            return $this->redirectToRoute('listar_categorias');
        }

        $categoria->setNome($request->get('nome'));
        $this->categoriaRepository->salvar($categoria);
        $this->addFlash('success', 'Categoria salva!');
        return $this->redirectToRoute('listar_categorias');
    }

}
