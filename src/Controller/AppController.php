<?php

namespace App\Controller;

use App\Entity\Venda;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\VendaRepository;

final class AppController extends AbstractController
{
    public function __construct(
        private VendaRepository $vendaRepository
    ) {
    }

    #[Route('/app', name: 'app')]
    public function index(): Response
    {
        $todasVendas = $this->vendaRepository->findBy([], ['dataVenda' => 'DESC']);

        $faturamentoTotal = 0;
        $faturamentoHoje = 0;
        $qtdVendasHoje = 0;

        $dataHoje = (new \DateTime())->format('Y-m-d');

        foreach ($todasVendas as $venda) {
            if ($venda->getStatus() == Venda::STATUS_FINALIZADA) {
                $valorVenda = $venda->getValorTotal();
                $faturamentoTotal += $valorVenda;
            }

            if ($venda->getDataVenda() !== null && $venda->getDataVenda()->format('Y-m-d') === $dataHoje && $venda->getStatus() == Venda::STATUS_FINALIZADA) {
                $faturamentoHoje += $valorVenda;
                $qtdVendasHoje++;
            }
        }

        $ultimasVendas = array_slice($todasVendas, 0, 5);

        return $this->render('/app/index.html.twig', [
            'vendas' => $ultimasVendas,
            'faturamentoTotal' => $faturamentoTotal,
            'numeroVendas' => count($todasVendas),
            'faturamentoHoje' => $faturamentoHoje,
            'qtdVendasHoje' => $qtdVendasHoje
        ]);
    }

    #[Route('/sobre', name: 'app_sobre')]
    public function sobre(): Response
    {
        return $this->render('app/sobre.html.twig');
    }


}
