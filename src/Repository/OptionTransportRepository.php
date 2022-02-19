<?php

namespace App\Repository;

use App\Entity\OptionTransport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OptionTransport|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionTransport|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionTransport[]    findAll()
 * @method OptionTransport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionTransportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionTransport::class);
    }

    // /**
    //  * @return OptionTransport[] Returns an array of OptionTransport objects
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
    public function findOneBySomeField($value): ?OptionTransport
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
