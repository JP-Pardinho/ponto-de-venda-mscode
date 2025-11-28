<?php

namespace App\Controller\Cliente\Criar;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Service\Cliente\ClienteService;
use App\Exception\Cliente\ClienteInvalidDataException;
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

    #[Route('/clientes/novo', name: 'clientes_novo', methods: ['GET', 'POST'])]
    public function novo(Request $request): Response
    {
        $cliente = new Cliente();

        $form = $this->createForm(ClienteType::class, $cliente, [
            'is_edit' => false,
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->clienteService->criar($cliente);
                $this->addFlash('success', 'Cliente cadastrado com sucesso!');
                return $this->redirectToRoute('clientes_index');
            } catch (ClienteInvalidDataException $e) {
                $this->addFlash('danger', $e->getMessage());
            } catch (\Throwable $e) {
                $this->addFlash('danger', 'Erro ao cadastrar cliente.');
            }
        }

        return $this->render('cliente/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
