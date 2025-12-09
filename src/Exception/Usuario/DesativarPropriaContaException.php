<?php 

namespace App\Exception\Usuario;

use Exception;

class DesativarPropriaContaException extends Exception
{
    public function __construct()
    {
        return parent::__construct('Operação negada: Você não pode desativar sua própria conta.');
    }
}