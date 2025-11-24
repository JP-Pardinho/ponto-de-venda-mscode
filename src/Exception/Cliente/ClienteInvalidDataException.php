<?php

namespace App\Exception\Cliente;

use Exception;

class ClienteInvalidDataException extends Exception
{
    public function __construct(string $message = 'Dados do cliente inválidos.')
    {
        parent::__construct($message);
    }
}
