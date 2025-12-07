<?php

namespace App\Entity;

use App\Repository\PagamentoVendaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PagamentoVendaRepository::class)]
class PagamentoVenda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $valor = null;

    #[ORM\Column(length: 50)]
    private ?string $tipoPagamento = null;

    #[ORM\Column]
    private ?int $parcelas = 1;

    #[ORM\ManyToOne(inversedBy: 'pagamentos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Venda $venda = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): static
    {
        $this->valor = $valor;

        return $this;
    }

    public function getTipoPagamento(): ?string
    {
        return $this->tipoPagamento;
    }

    public function setTipoPagamento(string $tipoPagamento): static
    {
        $this->tipoPagamento = $tipoPagamento;

        return $this;
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

    public function getParcelas(): ?int
    {
        return $this->parcelas;
    }

    public function setParcelas(int $parcelas): static
    {
        $this->parcelas = $parcelas;
        return $this;
    }
}
