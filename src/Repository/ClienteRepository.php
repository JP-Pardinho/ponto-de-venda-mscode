<?php

namespace App\Repository;

use App\Entity\Cliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cliente::class);
    }

    public function salvar(Cliente $cliente): void
    {
        $em = $this->getEntityManager();
        $em->persist($cliente);
        $em->flush();
    }

    public function remover(Cliente $cliente): void
    {
        $em = $this->getEntityManager();
        $em->remove($cliente);
        $em->flush();
    }

    public function findAllOrdenadoPorNome(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.nome', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function buscarPorNomeOuCpf(string $busca): array
    {
        $busca = trim($busca);

        if ($busca === '') {
            return $this->findAllOrdenadoPorNome();
        }

        $cpf = preg_replace('/\D/', '', $busca);

        return $this->createQueryBuilder('c')
            ->where('c.nome LIKE :nome')
            ->orWhere('c.cpf LIKE :cpf')
            ->setParameter('nome', '%' . $busca . '%')
            ->setParameter('cpf', '%' . $cpf . '%')
            ->orderBy('c.nome', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
