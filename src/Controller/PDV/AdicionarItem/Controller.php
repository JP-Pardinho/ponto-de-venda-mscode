<?php

namespace App\Controller\PDV\AdicionarItem;

use App\Form\VendaItemType;
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

    #[Route('/pdv/{id}/adicionar-item', name: 'pdv_adicionar_item', methods: ['POST'])]
    public function __invoke(int $id, Request $request): Response
    {
        $form = $this->createForm(VendaItemType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\VendaItem $itemFormulario */
            $itemFormulario = $form->getData(); 

            $produto = $itemFormulario->getProduto();
            $quantidade = $itemFormulario->getQuantidade();

            try {
                $this->vendaService->adicionarItem($id, $produto->getId(), $quantidade);
                $this->addFlash('success', 'Item adicionado!');
            } catch (\App\Exception\Produto\ProdutoEstoqueIndisponivelException $p) {
                $this->addFlash('danger', $p->getMessage() . ' (Estoque disponivel: ' . $produto->getQuantidadeEstoque() . ')' );
            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());
            }
        } else {
            $erro = (string) $form->getErrors(true, false);
            $this->addFlash('warning', 'Erro ao validar: ' . $erro);
        }

        return $this->redirectToRoute('pdv_pdv', ['id' => $id]);
    }
}