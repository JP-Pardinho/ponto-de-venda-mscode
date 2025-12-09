<?php

namespace App\Service\Cliente;

use App\Entity\Cliente;
use App\Exception\Cliente\ClienteInvalidDataException;
use App\Exception\Cliente\ClienteNaoEncontradoException;
use App\Exception\Cliente\ClienteTemVendasException;
use App\Repository\ClienteRepository;

class ClienteService
{
    public function __construct(
        private ClienteRepository $clienteRepository
    ) {}

    private function normalizarCpf(Cliente $cliente): void
    {
        $cpf = $cliente->getCpf() ?? '';

        $cpf = preg_replace('/\D/', '', $cpf);

        if ($cpf === '' || $cpf === null) {
            throw new ClienteInvalidDataException('O CPF é obrigatório.');
        }

        if (strlen($cpf) > 11) {
            throw new ClienteInvalidDataException('O CPF não pode ter mais de 11 dígitos.');
        }

        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        $cliente->setCpf($cpf);
    }

    public function criar(Cliente $cliente): void
    {
        if (empty(trim($cliente->getNome()))) {
            throw new ClienteInvalidDataException("O nome não pode ficar vazio.");
        }

        $this->normalizarCpf($cliente);

        $cliente->setAtivo(true);
        $cliente->setCreatedAt(new \DateTimeImmutable());

        $this->clienteRepository->salvar($cliente);
    }

    public function editar(Cliente $cliente): void
    {
        if (!$cliente->getId()) {
            throw new ClienteNaoEncontradoException();
        }

        if (empty(trim($cliente->getNome()))) {
            throw new ClienteInvalidDataException("O nome não pode ficar vazio.");
        }

        $this->normalizarCpf($cliente);

        $this->clienteRepository->salvar($cliente);
    }

    public function desativar(Cliente $cliente): void
    {
        if (!$cliente->getId()) {
            throw new ClienteNaoEncontradoException();
        }

        // if (!$cliente->getCompras()->isEmpty()) {
        //     throw new ClienteTemVendasException();
        // }

        $cliente->setAtivo(false);
        $this->clienteRepository->salvar($cliente);
    }

    public function restaurar(Cliente $cliente): void
    {
        if (!$cliente->getId()) {
            throw new ClienteNaoEncontradoException();
        }

        $cliente->setAtivo(true);
        $this->clienteRepository->salvar($cliente);
    }
}
