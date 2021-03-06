<?php

namespace App\Repository;

use App\Entity\Logement;
use App\Filter\LogementSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Logement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Logement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Logement[]    findAll()
 * @method Logement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logement::class);
    }
    //Fonction pour récuprer les logements par user $value c'est l'ulisateur authentifier
    public function findLogementByUser($value,LogementSearch $search)
    {
        if ($search->getId()){
            return $this->createQueryBuilder('l') //prefix de pour l'entité au lieu d'ecrire LOGEMENT
                 ->andWhere('l.hote = :val')
                ->andWhere('l.id = :id')
                ->setParameter('val', $value)
                ->setParameter('id',$search->getId())
                ->getQuery()
                ->getResult();
        }
        if ($search->getName()){
            return $this->createQueryBuilder('l')
                ->andWhere('l.hote = :val')
                ->andWhere('l.titre LIKE :name')
                ->setParameter('val', $value)
                ->setParameter('name',$search->getName())
                ->orderBy('l.id', 'ASC')
                ->getQuery()
                ->getResult();
        }


        return $this->createQueryBuilder('l')
            ->andWhere('l.hote = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getActiveLogement(){

        return $this->createQueryBuilder('l')
                ->andWhere('l.isActive = :val')
                ->setParameter(':val',true)
                ->orderBy('l.id','ASC')
                ->getQuery()
                ->getResult();
    }
    // /**
    //  * @return Logement[] Returns an array of Logement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Logement
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
