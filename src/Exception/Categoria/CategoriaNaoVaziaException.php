<?php 

namespace App\Exception\Categoria;
use Exception;

class CategoriaNaoVaziaException extends Exception 
{
    public function __construct()
    {
        return parent::__construct('Não foi possível remover essa categoria, pois ela está vinculada a um ou mais produtos.');
    }
}