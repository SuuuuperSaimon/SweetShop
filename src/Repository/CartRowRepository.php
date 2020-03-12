<?php

namespace App\Repository;

use App\Entity\CartRow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CartRow|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartRow|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartRow[]    findAll()
 * @method CartRow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartRow::class);
    }

    // /**
    //  * @return CartRow[] Returns an array of CartRow objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CartRow
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
