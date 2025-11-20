<?php 

namespace App\Exception\Categoria;

use Exception;
use Throwable;

class CategoriaQuantidadeInvalidaException extends Exception 
{
    public function __construct()
    {
        return parent::__construct('A quantidade para entrada deve ser positiva.');
    }
}