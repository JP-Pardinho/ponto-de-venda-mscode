<?php 

namespace App\Exception\Usuario;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class UsuarioInativoException extends CustomUserMessageAuthenticationException
{
    public function __construct()
    {
        return parent::__construct("Sua conta está inativa.");
    }
}