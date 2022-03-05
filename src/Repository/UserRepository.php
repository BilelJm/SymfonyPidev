<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use League\OAuth2\Client\Provider\GithubResourceOwner;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOrCreateFromGithubOauth(GithubResourceOwner $owner): User
    {
        /** @var User|null $user */
        $user= $this->createQueryBuilder('u')
            ->where('u.githubId= :githubId')
            ->orWhere('u.email= :email')
            ->setParameters([
                'email' =>$owner->getEmail(),
                'githubId' =>$owner->getId()
            ])
            ->getQuery()
            ->getOneOrNullResult();
        if ($user){

            if($user->getGithubId() === null){
                $user->setGithubId($owner->getId());
                $this->getEntityManager()->flush();
            }
            return $user;
        }
        $user =(new User())
            ->setUsername($owner->getNickname())
            ->setFirstName($owner->getName())
            ->setLastName($owner->getName())
            ->setGithubId($owner->getId())
            ->setEmail($owner->getEmail());

        $em= $this->getEntityManager();
        $em->persist($user);
        $em->flush();


        return $user;
    }


}
