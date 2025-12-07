<?php

namespace App\Controller\PDV\NovaVenda;

use App\Entity\Venda;
use App\Repository\VendaRepository;
use App\Service\Venda\VendaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private VendaService $vendaService,
        private VendaRepository $vendaRepository,
    ) {
    }

    #[Route('/pdv/novaVenda', name: 'pdv_novaVenda', methods: 'GET')]
    public function __invoke(): Response
    {
        /** @var \App\Entity\Usuario $user */
        $user = $this->getUser();
        $usuarioId = $user->getId();

        $vendaAberta = $this->vendaRepository->findOneBy([
            'usuario' => $usuarioId,
            'status' => Venda::STATUS_ABERTA,
        ]);

        if ($vendaAberta) {
            return $this->redirectToRoute('pdv_pdv', [
                'id' => $vendaAberta->getId(),
            ]);
        }

        try {
            $novaVenda = $this->vendaService->iniciaVenda($usuarioId);
            
            return $this->redirectToRoute('pdv_pdv', [
                'id' => $novaVenda->getId(),
            ]);

        } catch (\Exception $e) {
            $this->addFlash('danger', 'Erro ao iniciar venda: ' . $e->getMessage());
            return $this->redirectToRoute('app');
        }
    }
}