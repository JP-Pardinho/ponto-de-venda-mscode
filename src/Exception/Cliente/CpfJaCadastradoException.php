<?php

namespace App\Exception\Cliente;
use Exception;

class CpfJaCadastradoException extends Exception
{
    public function __construct()
    {
        parent::__construct('O CPF informado já está cadastrado.');
    }
}
