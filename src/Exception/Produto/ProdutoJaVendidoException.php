<?php 

namespace App\Exception\Produto;
use Exception;

class ProdutoJaVendidoException extends Exception 
{
    public function __construct()
    {
        parent::__construct('Não é possível deletar produto, pois ele está vinculado a uma ou mais vendas!');
    }
}