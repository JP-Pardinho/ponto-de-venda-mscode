<?php 

namespace App\Exception\Usuario;

use Exception;


class DesativarContaAdminException extends Exception
{
    public function __construct()
    {
        return parent::__construct('Operação negada: Não é permitido desativar contas de Gerentes.');
    }
}