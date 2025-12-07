<?php 

namespace App\Exception\Venda;

use Exception;

class PagamentoInsuficienteException extends Exception
{
    public function __construct()
    {
        return parent::__construct('Valor pago é menor que o total da venda!');
    }
}