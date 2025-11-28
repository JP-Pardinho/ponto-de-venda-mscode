<?php

namespace App\Controller\Cliente\Restaurar;

use App\Entity\Cliente;
use App\Service\Cliente\ClienteService;
use App\Exception\Cliente\ClienteNaoEncontradoException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    public function __construct(
        private ClienteService $clienteService
    ) {
    }

    #[Route('/clientes/{id}/restaurar', name: 'clientes_restaurar', methods: ['POST'])]
    public function restaurar(Cliente $cliente, Request $request): Response
    {
        if (! $cliente) {
            $this->addFlash('danger', 'Cliente não encontrado.');
            return $this->redirectToRoute('clientes_index');
        }

        $token = $request->request->get('_token');

        if (! $this->isCsrfTokenValid('restore' . $cliente->getId(), $token)) {
            $this->addFlash('danger', 'Token CSRF inválido.');
            return $this->redirectToRoute('clientes_index');
        }

        try {
            $this->clienteService->restaurar($cliente);
            $this->addFlash('success', 'Cliente reativado com sucesso!');
        } catch (ClienteNaoEncontradoException $e) {
            $this->addFlash('danger', $e->getMessage());
        } catch (\Throwable $e) {
            $this->addFlash('danger', 'Erro ao reativar cliente.');
        }

        return $this->redirectToRoute('clientes_index');
    }
}
