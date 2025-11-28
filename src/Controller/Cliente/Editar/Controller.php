<?php

namespace App\Controller\Cliente\Editar;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Service\Cliente\ClienteService;
use App\Exception\Cliente\ClienteInvalidDataException;
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

    #[Route('/clientes/{id}/editar', name: 'clientes_editar', methods: ['GET', 'POST'])]
    public function editar(Cliente $cliente, Request $request): Response
    {
        if (! $cliente) {
            $this->addFlash('danger', 'Cliente não encontrado.');
            return $this->redirectToRoute('clientes_index');
        }

        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->clienteService->editar($cliente);
                $this->addFlash('success', 'Cliente atualizado com sucesso!');
                return $this->redirectToRoute('clientes_index');
            } catch (ClienteNaoEncontradoException $e) {
                $this->addFlash('danger', $e->getMessage());
            } catch (ClienteInvalidDataException $e) {
                $this->addFlash('danger', $e->getMessage());
            } catch (\Throwable $e) {
                $this->addFlash('danger', 'Erro ao atualizar cliente.');
            }
        }

        return $this->render('cliente/edit.html.twig', [
            'form'    => $form->createView(),
            'cliente' => $cliente,
        ]);
    }
}
