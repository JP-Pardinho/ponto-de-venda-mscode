<?php

namespace App\Controller\Cliente\Deletar;

use App\Entity\Cliente;
use App\Service\Cliente\ClienteService;
use App\Exception\Cliente\ClienteNaoEncontradoException;
use App\Exception\Cliente\ClienteTemVendasException;
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

    #[Route('/clientes/{id}/deletar', name: 'clientes_delete', methods: ['POST'])]
    public function deletar(Cliente $cliente, Request $request): Response
    {
        if (! $cliente) {
            $this->addFlash('danger', 'Cliente não encontrado.');
            return $this->redirectToRoute('clientes_index');
        }

        $token = $request->request->get('_token');

        if (! $this->isCsrfTokenValid('delete' . $cliente->getId(), $token)) {
            $this->addFlash('danger', 'Token CSRF inválido.');
            return $this->redirectToRoute('clientes_index');
        }

        try {
            $this->clienteService->desativar($cliente);
            $this->addFlash('success', 'Cliente desativado com sucesso!');
        } catch (ClienteTemVendasException $e) {
            $this->addFlash('danger', $e->getMessage());
        } catch (ClienteNaoEncontradoException $e) {
            $this->addFlash('danger', $e->getMessage());
        } catch (\Throwable $e) {
            $this->addFlash('danger', 'Erro ao desativar cliente.');
        }

        return $this->redirectToRoute('clientes_index');
    }
}
