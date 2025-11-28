<?php

namespace App\Exception\Cliente;

use Exception;

class ClienteNaoEncontradoException extends Exception
{
    public function __construct()
    {
        parent::__construct('Cliente não encontrado.');
    }
}
