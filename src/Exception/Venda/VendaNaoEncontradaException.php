<?php 

namespace App\Exception\Venda;

use Exception;

class VendaNaoEncontradaException extends Exception
{
    public function __construct()
    {
        return parent::__construct('Venda não encontrada!');
    }
}