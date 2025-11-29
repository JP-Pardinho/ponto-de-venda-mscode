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

        public function buscarPorNomeOuCpf(string $busca): array
    {
        $busca = trim($busca);

        $qb = $this->createQueryBuilder('c')
              ->orderBy('c.nome', 'ASC');

        if ($busca !== '') {
            $cpf = preg_replace('/\D/', '', $busca);

            $qb->where('c.nome LIKE :termoGeral')
               ->setParameter('termoGeral', '%' . $busca . '%');

            if (!empty($cpf)) {
                $qb->orWhere('c.cpf LIKE :termoCpf')
                   ->setParameter('termoCpf', '%' . $cpf . '%');        
            }
      }

        return $qb->getQuery()->getResult();
    }
}
