<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descricao = null;

    #[ORM\Column]
    private ?int $quantidadeInicial = null;

    #[ORM\Column]
    private ?int $quantidadeEstoque = null;

    #[ORM\ManyToOne(inversedBy: 'produtos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categoria $categoria = null;

    /**
     * @var Collection<int, VendaItem>
     */
    #[ORM\OneToMany(targetEntity: VendaItem::class, mappedBy: 'produto')]
    private Collection $vendaItems;

    public function __construct()
    {
        $this->vendaItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): static
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getQuantidadeInicial(): ?int
    {
        return $this->quantidadeInicial;
    }

    public function setQuantidadeInicial(int $quantidadeInicial): static
    {
        $this->quantidadeInicial = $quantidadeInicial;

        return $this;
    }

    public function getQuantidadeEstoque(): ?int
    {
        return $this->quantidadeEstoque;
    }

    public function setQuantidadeEstoque(int $quantidadeEstoque): static
    {
        $this->quantidadeEstoque = $quantidadeEstoque;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

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
            $vendaItem->setProduto($this);
        }

        return $this;
    }

    public function removeVendaItem(VendaItem $vendaItem): static
    {
        if ($this->vendaItems->removeElement($vendaItem)) {
            // set the owning side to null (unless already changed)
            if ($vendaItem->getProduto() === $this) {
                $vendaItem->setProduto(null);
            }
        }

        return $this;
    }
}
