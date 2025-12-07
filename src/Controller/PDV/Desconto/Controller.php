<?php

namespace App\Controller\PDV\Desconto;

use App\Service\Venda\VendaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private VendaService $vendaService,
    ) {
    }

    #[Route('/pdv/{id}/desconto', name: 'pdv_aplicar_desconto', methods: ['POST'])]
    public function __invoke(int $id, Request $request): Response
    {
        $valorDesconto = (float) $request->request->get('desconto', 0);

        try {
            $this->vendaService->aplicarDesconto($id, $valorDesconto);
            $this->addFlash('success', 'Desconto aplicado com sucesso!');
        } catch (\Exception $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->redirectToRoute('pdv_pdv', [
            'id' => $id,
        ]);
    }
}