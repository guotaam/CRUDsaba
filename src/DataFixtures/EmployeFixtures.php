<?php

namespace App\DataFixtures;
use App\Entity\Employe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 10; $i++)
        {
        $employe = new Employe();
         
        $employe->setPrenom("prénom employé $i")
        ->setNom("nom employé $i")
        ->setTelephone("num tel employé $i")
        ->setEmail("email employé $i")
        ->setAdresse("<p>adresse n°$i</p>")
        ->setPoste("poste employé $i")
        ->setSalaire("salaire employé $i")
        ->setDatedenaissance(new \DateTime());
        


        $manager->persist($employe);
    }
        $manager->flush();
    }
}
