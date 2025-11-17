<?php 

namespace App\Service\Produto;
use Exception;

class VerificaProdutoVendidoException extends Exception {

    public function __construct()
    {
        parent::__construct('Não é possível deletar produto, pois ele está vinculado a uma ou mais vendas!');
    }
}