<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Facture;
class FactFixtures extends Fixture
{ public function load(ObjectManager $manager): void
    {
    for($i =1; $i<10;$i++){
$fact =new Facture();
$fact-> setIdFacture("ID de la Facture  ");




$manager->persist($fact);  }
        $manager->flush();

           
}
}