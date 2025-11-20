<?php 

namespace App\Service\Categoria;

use App\Entity\Categoria;
use App\Exception\Categoria\CategoriaNaoVaziaException as CategoriaCategoriaNaoVaziaException;
use App\Repository\CategoriaRepository;

class CategoriaService 
{
    public function __construct(
        private CategoriaRepository $categoriaRepository
    ) {
    }

    public function salvar(Categoria $categoria): void 
    {
        $this->categoriaRepository->salvar($categoria);
    }

    public function remover(Categoria $categoria): void 
    {
        if (! $categoria->getProdutos()->isEmpty()) {
            throw new CategoriaCategoriaNaoVaziaException();
        }

        $this->categoriaRepository->remover($categoria);
        
    }

}