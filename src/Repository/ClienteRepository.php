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

        $apenasNumeros = preg_replace('/\D/', '', $busca);
        
        $qb = $this->createQueryBuilder('c')
            ->where('c.nome LIKE :termoGeral')
            ->setParameter('termoGeral', '%' . $busca . '%')
            ->orderBy('c.nome', 'ASC');

        if (strlen($apenasNumeros) === 11) {
            
            $cpfCriptografado = Cliente::criptografarParaBusca($apenasNumeros);

            $qb->orWhere('c.cpf = :cpfExato')
               ->setParameter('cpfExato', $cpfCriptografado);
        }

        return $qb->getQuery()->getResult();
    }
}