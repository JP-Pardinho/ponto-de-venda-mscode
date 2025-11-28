<?php

namespace App\Controller\Cliente\Ver;

use App\Entity\Cliente;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    #[Route('/clientes/{id}', name: 'clientes_ver', methods: ['GET'])]
    public function ver(Cliente $cliente): Response
    {
        if (! $cliente) {
            $this->addFlash('danger', 'Cliente não encontrado.');
            return $this->redirectToRoute('clientes_index');
        }

        return $this->render('cliente/show.html.twig', [
            'cliente' => $cliente,
        ]);
    }
}
