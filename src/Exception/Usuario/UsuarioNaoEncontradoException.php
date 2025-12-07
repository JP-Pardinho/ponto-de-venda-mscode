<?php 

namespace App\Exception\Usuario;

use Exception;

class UsuarioNaoEncontradoException extends Exception
{
    public function __construct()
    {
        return parent::__construct('Usuário não encontrado!');
    }
}