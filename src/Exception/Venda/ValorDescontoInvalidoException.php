<?php 

namespace App\Exception\Venda;

use Exception;

class ValorDescontoInvalidoException extends Exception
{
    public function __construct()
    {
        return parent::__construct('O valor do desconto não pode ser maior que o total da venda!');
    }
}