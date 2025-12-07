<?php 

namespace App\Exception\Produto;
use Exception;

class ProdutoEstoqueIndisponivelException extends Exception 
{
    public function __construct()
    {
        parent::__construct('Estoque insuficiente!');
    }
}