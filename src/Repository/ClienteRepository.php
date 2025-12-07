<?php

namespace App\Repository;

use App\Entity\Cliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use App\Exception\Cliente\CpfJaCadastradoException;
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

    try {
        $em->persist($cliente);
        $em->flush();
    } catch (UniqueConstraintViolationException $e) {
        throw new CpfJaCadastradoException();
    }
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

        $qb = $this->createQueryBuilder('c')
            ->where('c.nome LIKE :termoGeral')
            ->setParameter('termoGeral', '%' . $busca . '%')
            ->orderBy('c.nome', 'ASC');

        if (!empty($cpf)) {
            $qb->orWhere('c.cpf LIKE :termoCpf')
            ->setParameter('termoCpf', '%' . $cpf . '%');
        }

        return $qb->getQuery()->getResult();
    }
}
