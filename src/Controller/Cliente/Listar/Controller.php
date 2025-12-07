<?php

namespace App\Controller\Cliente\Listar;

use App\Repository\ClienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    public function __construct(
        private ClienteRepository $clienteRepository
    ) {
    }

    #[Route('/clientes', name: 'clientes_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $q = $request->query->get('q', '');

            $clientes = $this->clienteRepository->buscarPorNomeOuCpf($q);

        return $this->render('cliente/index.html.twig', [
            'clientes' => $clientes,
            'q'        => $q,
        ]);
    }
}
