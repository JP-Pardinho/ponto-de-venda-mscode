<?php 

namespace App\Exception\Usuario;

use Exception;
use Throwable;

class SenhaObrigatoriaException extends Exception
{
    public function __construct()
    {
        return parent::__construct("Informe a senha para poder salvar o usuário");
    }
}