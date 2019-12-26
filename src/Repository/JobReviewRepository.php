<?php

namespace App\Repository;

use App\Entity\JobReview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JobReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobReview[]    findAll()
 * @method JobReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobReview::class);
    }

    // /**
    //  * @return JobReview[] Returns an array of JobReview objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JobReview
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
