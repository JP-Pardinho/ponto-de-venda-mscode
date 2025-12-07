<?php 

namespace App\Exception\Produto;
use Exception;

class ProdutoNaoEncontradoException extends Exception 
{
    public function __construct()
    {
        parent::__construct('Produto não encontrado!');
    }
}