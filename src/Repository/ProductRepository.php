<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function FindLastId() 
    {
        return $this->createQueryBuilder('o')

            ->orderBy('o.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ; 
    }

        public function FindLastFourID()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.id', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
            ; 
    }

    public function FindStuff($pcstuff){
        $qb = $this->createQueryBuilder('op') // op = one product
                    ->innerJoin('op.pcstuff', 'ps')
                    ->andWhere('ps = :pcstuff')
                    ->setParameter('pcstuff', $pcstuff);

        // dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();
    }
}
