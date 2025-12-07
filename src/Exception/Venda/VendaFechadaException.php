<?php 

namespace App\Exception\Venda;

use Exception;

class VendaFechadaException extends Exception
{
    public function __construct()
    {
        return parent::__construct('Está venda já está fechada!');
    }
}