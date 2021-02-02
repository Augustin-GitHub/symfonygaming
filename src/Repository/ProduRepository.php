<?php

namespace App\Repository;

use App\Entity\Produ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produ|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produ|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produ[]    findAll()
 * @method Produ[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produ::class);
    }

    // /**
    //  * @return Produ[] Returns an array of Produ objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produ
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
