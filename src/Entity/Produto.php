<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
#[UniqueEntity(
    fields: ['nome'], 
    message: 'Este nome de produto já existe.',
    errorPath: 'nome'
)]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'O nome não pode ficar em branco.')]
    private ?string $nome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descricao = null;

    #[ORM\Column]
    #[Assert\Positive(message: 'A quantidade não pode ser menor ou igual a zero')]
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

    #[ORM\Column]
    #[Assert\Positive(message: 'O preço deve ser positivo')]
    private ?float $valor = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dataCadastro = null;

    #[ORM\Column]
    private ?bool $ativo = null;

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

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): static
    {
        $this->valor = $valor;

        return $this;
    }

    public function getDataCadastro(): ?\DateTime
    {
        return $this->dataCadastro;
    }

    public function setDataCadastro(\DateTime $dataCadastro): static
    {
        $this->dataCadastro = $dataCadastro;

        return $this;
    }

    public function isAtivo(): ?bool
    {
        return $this->ativo;
    }

    public function setAtivo(bool $ativo): static
    {
        $this->ativo = $ativo;

        return $this;
    }
}
