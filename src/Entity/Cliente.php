<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $cpf = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefone = null;

    /**
     * @var Collection<int, Venda>
     */
    #[ORM\OneToMany(targetEntity: Venda::class, mappedBy: 'cliente')]
    private Collection $compras;

    public function __construct()
    {
        $this->compras = new ArrayCollection();
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

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): static
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(?string $telefone): static
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * @return Collection<int, Venda>
     */
    public function getCompras(): Collection
    {
        return $this->compras;
    }

    public function addCompra(Venda $compra): static
    {
        if (!$this->compras->contains($compra)) {
            $this->compras->add($compra);
            $compra->setCliente($this);
        }

        return $this;
    }

    public function removeCompra(Venda $compra): static
    {
        if ($this->compras->removeElement($compra)) {
            // set the owning side to null (unless already changed)
            if ($compra->getCliente() === $this) {
                $compra->setCliente(null);
            }
        }

        return $this;
    }
}
