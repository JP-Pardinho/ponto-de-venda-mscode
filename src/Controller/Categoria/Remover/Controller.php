<?php

namespace App\Controller\Categoria\Remover;

use App\Entity\Categoria;
use App\Service\Categoria\CategoriaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

final class Controller extends AbstractController
{
    public function __construct(
        private CategoriaService $categoriaService
    ) {  
    }

    #[Route('/categorias/remover/{categoria}', name: 'remover_categoria', methods:'GET')]
    public function remover(?Categoria $categoria): Response
    {
        try {
            $this->categoriaService->remover($categoria);
            $this->addFlash('success', 'Categoria removida com sucesso!');
        } catch (Throwable $e) {
            $this->addFlash('danger', $e->getMessage());
        }
       
        return $this->redirectToRoute('listar_categorias');
    }
}
