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
    public const STATUS_ABERTA = 0;
    public const STATUS_FINALIZADA = 1;
    public const STATUS_CANCELADA = 2;
    
    public const TIPO_RETIRADA = 'RETIRADA';
    public const TIPO_ENTREGA = 'ENTREGA';


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'compras')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Cliente $cliente = null;

    #[ORM\ManyToOne(inversedBy: 'vendas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $dataVenda = null;

    #[ORM\Column]
    private ?float $valorTotal = null;
    
    #[ORM\Column(nullable: true)]
    private ?float $valorDesconto = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = self::STATUS_ABERTA;

    #[ORM\Column(length: 20)]
    private ?string $tipoEntrega = self::TIPO_RETIRADA;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enderecoEntrega = null;

    #[ORM\Column(nullable: true)]
    private ?float $troco = 0.0;

    /**
     * @var Collection<int, VendaItem>
     */
    #[ORM\OneToMany(targetEntity: VendaItem::class, cascade: ['persist'], mappedBy: 'venda')]
    private Collection $vendaItems;

    /**
     * @var Collection<int, PagamentoVenda>
     */
    #[ORM\OneToMany(targetEntity: PagamentoVenda::class, mappedBy: 'venda', cascade: ['persist'], orphanRemoval: true)]
    private Collection $pagamentos;

    public function __construct()
    {
        $this->vendaItems = new ArrayCollection();
        $this->status = self::STATUS_ABERTA;
        $this->pagamentos = new ArrayCollection();
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

    public function getValorDesconto(): ?float
    {
        return $this->valorDesconto;
    }

    public function setValorDesconto(?float $valorDesconto): static
    {
        $this->valorDesconto = $valorDesconto;
        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function StatusTexto(): string
    {
        return match($this->status) {
            self::STATUS_ABERTA => 'Venda em Aberto',
            self::STATUS_FINALIZADA => 'Venda Finalizada',
            self::STATUS_CANCELADA => 'Venda Cancelada',
            default => 'Status Desconhecido'
        };
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getTipoEntrega(): ?string
    {
        return $this->tipoEntrega;
    }

    public function setTipoEntrega(string $tipoEntrega): static
    {
        $this->tipoEntrega = $tipoEntrega;
        return $this;
    }

    public function getEnderecoEntrega(): ?string
    {
        return $this->enderecoEntrega;
    }

    public function setEnderecoEntrega(?string $enderecoEntrega): static
    {
        $this->enderecoEntrega = $enderecoEntrega;
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

    /**
     * @return Collection<int, PagamentoVenda>
     */
    public function getPagamentos(): Collection
    {
        return $this->pagamentos;
    }

    public function addPagamento(PagamentoVenda $pagamento): static
    {
        if (!$this->pagamentos->contains($pagamento)) {
            $this->pagamentos->add($pagamento);
            $pagamento->setVenda($this);
        }

        return $this;
    }

    public function removePagamento(PagamentoVenda $pagamento): static
    {
        if ($this->pagamentos->removeElement($pagamento)) {
            // set the owning side to null (unless already changed)
            if ($pagamento->getVenda() === $this) {
                $pagamento->setVenda(null);
            }
        }

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
}
