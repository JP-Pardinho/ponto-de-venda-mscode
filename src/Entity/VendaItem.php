<?php

namespace App\Entity;

use App\Repository\VendaItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VendaItemRepository::class)]
class VendaItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vendaItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Venda $venda = null;

    #[ORM\ManyToOne(inversedBy: 'vendaItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produto $produto = null;

    #[ORM\Column]
    private ?int $quantidade = null;

    #[ORM\Column]
    private ?float $valorAtualProduto = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVenda(): ?Venda
    {
        return $this->venda;
    }

    public function setVenda(?Venda $venda): static
    {
        $this->venda = $venda;

        return $this;
    }

    public function getProduto(): ?Produto
    {
        return $this->produto;
    }

    public function setProduto(?Produto $produto): static
    {
        $this->produto = $produto;

        return $this;
    }

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): static
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    public function getValorAtualProduto(): ?float
    {
        return $this->valorAtualProduto;
    }

    public function setValorAtualProduto(float $valorAtualProduto): static
    {
        $this->valorAtualProduto = $valorAtualProduto;

        return $this;
    }
}
