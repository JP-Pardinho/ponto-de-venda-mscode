<?php 

namespace App\Exception\Venda;

use Exception;

class RemoverItemVendaFechadaException extends Exception
{
    public function __construct()
    {
        return parent::__construct('Não é possível remover itens de uma venda fecahda!');
    }
}