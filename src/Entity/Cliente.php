<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(length: 255, unique: true)]
    private ?string $cpf = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefone = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private ?bool $ativo = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(targetEntity: Venda::class, mappedBy: 'cliente')]
    private Collection $compras;

    public function __construct()
    {
        $this->compras = new ArrayCollection();
    }

    private static function getChaveSecreta(): string
    {
        $chave = $_SERVER['CPF_SECRET_KEY'] ?? $_ENV['CPF_SECRET_KEY'] ?? null;

        if (empty($chave)) {
            throw new \RuntimeException('A variável CPF_SECRET_KEY não foi definida no arquivo .env');
        }
        return $chave;
    }

    private function getFixedIV(): string
    {
        return substr(hash('sha256', self::getChaveSecreta()), 0, 16);
    }

    public static function criptografarParaBusca(string $cpfLimpo): string
    {
        $chave = self::getChaveSecreta();
        $iv = substr(hash('sha256', $chave), 0, 16);

        $encrypted = \openssl_encrypt(
            $cpfLimpo,
            'aes-256-cbc',
            $chave,
            0,
            $iv
        );

        return base64_encode($encrypted);
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
        if (!$this->cpf) {
            return null;
        }

        $decrypted = \openssl_decrypt(
            base64_decode($this->cpf),
            'aes-256-cbc',
            self::getChaveSecreta(),
            0,
            $this->getFixedIV()
        );

        return $decrypted === false ? $this->cpf : $decrypted;
    }

    public function setCpf(string $cpf): static
    {
        $encrypted = \openssl_encrypt(
            $cpf,
            'aes-256-cbc',
            self::getChaveSecreta(),
            0,
            $this->getFixedIV()
        );

        $this->cpf = base64_encode($encrypted);
        return $this;
    }

    public function getCpfFormatado(): ?string
    {
        $cpf = $this->getCpf();

        if (empty($cpf)) {
            return null;
        }

        $cpfLimpo = preg_replace('/\D/', '', $cpf);

        return preg_replace(
            '/(\d{3})(\d{3})(\d{3})(\d{2})/',
            '$1.$2.$3-$4',
            $cpfLimpo
        );
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

    public function getTelefoneFormatado(): ?string
    {
        $telefone = $this->getTelefone();

        if (empty($telefone)) {
            return null;
        }

        $nums = preg_replace('/\D/', '', $telefone);

        if (strlen($nums) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $nums);
        }

        if (strlen($nums) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $nums);
        }

        return $telefone;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

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
            if ($compra->getCliente() === $this) {
                $compra->setCliente(null);
            }
        }
        return $this;
    }
}
