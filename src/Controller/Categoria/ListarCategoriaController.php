<?php

namespace App\Controller\Categoria;

use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListarCategoriaController extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository
    ){    
    }

    #[Route('/listar/categoria', name: 'listar_categoria', methods:'GET')]
    public function show(): Response
    {
        return $this->render('categoria/index.html.twig', [
            'categorias' => $this->categoriaRepository->findAll(),
        ]);
    }
}
