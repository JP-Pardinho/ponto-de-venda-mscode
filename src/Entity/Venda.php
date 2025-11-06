<?php

namespace App\Entity;

use App\Repository\VendaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VendaRepository::class)]
class Venda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'compras')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cliente $cliente = null;

    #[ORM\ManyToOne(inversedBy: 'vendas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dataVenda = null;

    #[ORM\Column]
    private ?float $valorTotal = null;

    #[ORM\Column]
    private ?float $valorPago = null;

    #[ORM\Column(length: 255)]
    private ?string $formaPagamento = null;

    #[ORM\Column(nullable: true)]
    private ?float $troco = null;

    /**
     * @var Collection<int, VendaItem>
     */
    #[ORM\OneToMany(targetEntity: VendaItem::class, mappedBy: 'venda')]
    private Collection $vendaItems;

    public function __construct()
    {
        $this->vendaItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): static
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getDataVenda(): ?\DateTime
    {
        return $this->dataVenda;
    }

    public function setDataVenda(\DateTime $dataVenda): static
    {
        $this->dataVenda = $dataVenda;

        return $this;
    }

    public function getValorTotal(): ?float
    {
        return $this->valorTotal;
    }

    public function setValorTotal(float $valorTotal): static
    {
        $this->valorTotal = $valorTotal;

        return $this;
    }

    public function getValorPago(): ?float
    {
        return $this->valorPago;
    }

    public function setValorPago(float $valorPago): static
    {
        $this->valorPago = $valorPago;

        return $this;
    }

    public function getFormaPagamento(): ?string
    {
        return $this->formaPagamento;
    }

    public function setFormaPagamento(string $formaPagamento): static
    {
        $this->formaPagamento = $formaPagamento;

        return $this;
    }

    public function getTroco(): ?float
    {
        return $this->troco;
    }

    public function setTroco(?float $troco): static
    {
        $this->troco = $troco;

        return $this;
    }

    /**
     * @return Collection<int, VendaItem>
     */
    public function getVendaItems(): Collection
    {
        return $this->vendaItems;
    }

    public function addVendaItem(VendaItem $vendaItem): static
    {
        if (!$this->vendaItems->contains($vendaItem)) {
            $this->vendaItems->add($vendaItem);
            $vendaItem->setVenda($this);
        }

        return $this;
    }

    public function removeVendaItem(VendaItem $vendaItem): static
    {
        if ($this->vendaItems->removeElement($vendaItem)) {
            // set the owning side to null (unless already changed)
            if ($vendaItem->getVenda() === $this) {
                $vendaItem->setVenda(null);
            }
        }

        return $this;
    }
}
