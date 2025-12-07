<?php 

namespace App\Exception\Venda;

use Exception;

class ItemNaoEncontradoException extends Exception
{
    public function __construct()
    {
        return parent::__construct('Item não encontrado!');
    }
}