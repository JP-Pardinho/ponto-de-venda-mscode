<?php

namespace App\Controller\PDV;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PdvController extends AbstractController
{
    #[Route('/pdv/adicionar-produto', name: 'pdv_adicionar_produto')]
    public function adicionarProduto(): Response
    {
        return $this->render('pdv/adicionarProduto.html.twig');
    }
}
