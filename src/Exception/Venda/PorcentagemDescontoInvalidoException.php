<?php 

namespace App\Exception\Venda;

use Exception;

class PorcentagemDescontoInvalidoException extends Exception
{
    public function __construct()
    {
        return parent::__construct('Operadores só podem conceder até 10% de desconto. Chame um gerente.');
    }
}