<?php 

namespace App\Exception\Produto;
use Exception;

class NovoEstoqueException extends Exception 
{
    public function __construct(string $nome)
    {
        parent::__construct("Produto " . $nome . " ficou sem estoque durante a venda.");
    }
}