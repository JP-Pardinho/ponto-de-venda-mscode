<?php 

namespace App\Exception\Usuario;

use Exception;

class UsuarioInativoException extends Exception
{
    public function __construct()
    {
        return parent::__construct("Sua conta está inativa.");
    }
}