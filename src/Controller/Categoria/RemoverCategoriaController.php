<?php

namespace App\Controller\Categoria;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RemoverCategoriaController extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository,
        private ProdutoRepository $produtoRepository
    ) {  
    }

    #[Route('/categoria/remover/{categoria}', name: 'remover_categoria', methods:'GET')]
    public function remover(?Categoria $categoria): Response
    {
        if (!$categoria) {
            $this->addFlash('danger', 'Não foi possível encontrar a categoria!');
            return $this->redirectToRoute('listar_categorias');
        }

        $produtosVinculados = $this->produtoRepository->count(['categoria' => $categoria->getId('id')]);

        if ($produtosVinculados > 0) {
            $this->addFlash('danger', 'Não foi possível remover essa categoria, pois ela está vinculada a um ou mais produtos!');
            return $this->redirectToRoute('listar_categorias');
        }

        $this->categoriaRepository->remover($categoria);

        return $this->redirectToRoute('listar_categorias');
    }
}
