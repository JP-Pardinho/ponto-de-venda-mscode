<?php

namespace App\Repository;

use App\Entity\Produto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produto>
 */
class ProdutoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produto::class);
    }

    public function salvar(Produto $produto): void 
    {
        $this->getEntityManager()->persist($produto);
        $this->getEntityManager()->flush();
    }

    public function remover(Produto $produto) {
        $this->getEntityManager()->remove($produto);
        $this->getEntityManager()->flush();
    }

        public function buscarPorNome(string $busca): array
    {
        $busca = trim($busca);
        
        $qb = $this->createQueryBuilder('p')
            ->addSelect('c')
            ->leftJoin('p.categoria', 'c')
            ->orderBy('p.id', 'ASC');

        if ($busca !== '') {    
            $qb->where('p.nome LIKE :termoGeral')
               ->orWhere('c.nome LIKE :termoGeral')
               ->setParameter('termoGeral', '%' . $busca . '%');
        }

        return $qb->getQuery()->getResult();
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
