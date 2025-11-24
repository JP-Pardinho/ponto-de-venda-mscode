<?php

namespace App\Exception\Cliente;

use Exception;

class ClienteTemVendasException extends Exception
{
    public function __construct()
    {
        parent::__construct('Cliente não pode ser desativado porque possui vendas associadas.');
    }
}
