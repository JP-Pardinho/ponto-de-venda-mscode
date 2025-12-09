<?php

namespace App\Controller\Venda\CancelarVenda;

use App\Repository\VendaRepository;
use App\Service\Venda\VendaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class Controller extends AbstractController
{

    public function __construct( 
        private VendaService $vendaService,
        private VendaRepository $vendaRepository
    ) {
    }   

    #[Route('/vendas/{id}/cancelar-venda', name: 'cancelar_venda', methods:['POST', 'GET'])]
    public function cancelar(int $id): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', 'Acesso negado. Área restrita a administradores.');
            return $this->render('erro/erro.html.twig', [
                'erro' => Response::HTTP_FORBIDDEN
            ]);
        }

        $venda = $this->vendaRepository->find($id);


        try {
            $this->vendaService->cancelarVenda($venda);
            $this->addFlash('success', 'Venda cancelada!');
        } catch (\Exception $e) {
            $this->addFlash('danger', $e->getMessage());
            return $this->redirectToRoute('listar_vendas');
        }

        return $this->redirectToRoute('listar_vendas');
    }
}
