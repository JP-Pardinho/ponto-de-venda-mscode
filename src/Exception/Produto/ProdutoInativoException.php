<?php 

namespace App\Exception\Produto;
use Exception;

class ProdutoInativoException extends Exception 
{
    public function __construct()
    {
        parent::__construct("Este produto está inativo e não pode ser vendido");
    }
}