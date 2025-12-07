<?php

namespace App\Controller\Categoria\Listar;

use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository
    ){    
    }

    #[Route('/categorias', name: 'listar_categorias', methods:'GET')]
    public function show(Request $request): Response
    {

        $q = $request->query->get('q', '');

        $categorias = $this->categoriaRepository->buscarPorNome($q);

        return $this->render('categoria/index.html.twig', [
            'categorias' => $categorias,
            'q'          => $q,
        ]);
    }
}
