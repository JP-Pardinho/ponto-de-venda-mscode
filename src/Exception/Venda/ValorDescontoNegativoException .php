<?php 

namespace App\Exception\Venda;

use Exception;

class ValorDescontoNegativoException extends Exception
{
    public function __construct()
    {
        return parent::__construct('O valor do desconto não pode ser negativo!');
    }
}