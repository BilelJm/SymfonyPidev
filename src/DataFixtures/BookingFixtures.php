<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Booking;
class BookingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    for($i =1; $i<10;$i++){
$booking =new Booking();
$booking-> setIdReservation("ID de la reservation ");




$manager->persist($booking);  }
        $manager->flush();

           
}
}