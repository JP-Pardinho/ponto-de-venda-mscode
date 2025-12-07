<?php

namespace App\Controller\PDV\RemoverItem;

use App\Repository\VendaItemRepository;
use App\Service\Venda\VendaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private VendaService $vendaService,
        private VendaItemRepository $vendaItemRepository,
    ) {
    }

    #[Route('/pdv/item/{idItem}/remover', name: 'pdv_remover_item', methods: ['GET', 'POST'])]
    public function __invoke(int $idItem): Response
    {
        $item = $this->vendaItemRepository->find($idItem);
        
        if (!$item) {
            $this->addFlash('warning', 'Item não encontrado.');
            return $this->redirectToRoute('app');
        }
        
        $vendaId = $item->getVenda()->getId();

        try {
            $this->vendaService->removerItem($idItem);
            $this->addFlash('success', 'Item removido com sucesso!');
        } catch (\Exception $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->redirectToRoute('pdv_pdv', [
            'id' => $vendaId
        ]);
    }
}