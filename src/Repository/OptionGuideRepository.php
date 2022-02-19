<?php

namespace App\Repository;

use App\Entity\OptionGuide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OptionGuide|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionGuide|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionGuide[]    findAll()
 * @method OptionGuide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionGuideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionGuide::class);
    }

    // /**
    //  * @return OptionGuide[] Returns an array of OptionGuide objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OptionGuide
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
