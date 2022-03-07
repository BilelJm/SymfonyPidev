<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Reservations;
class ReservationsFixtures extends Fixture
{ public function load(ObjectManager $manager): void
    {
    for($i =125; $i<130;$i++){
$res =new Reservations();
$res-> setDureesejour(5);




$manager->persist($res);  }
        $manager->flush();

           
}
}