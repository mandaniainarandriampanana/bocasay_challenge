<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Genre;
use AppBundle\Entity\Types;
use AppBundle\Entity\Fournisseur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //genre
        $genre1 = new Genre();
        $genre1->setLibelle('Homme');
        $manager->persist($genre1);
        $genre2 = new Genre();
        $genre2->setLibelle('Femme');
        $manager->persist($genre2);
        $genre3 = new Genre();
        $genre3->setLibelle('Enfant');
        $manager->persist($genre3);
        $genre4 = new Genre();
        $genre4->setLibelle('Mixte');
        $manager->persist($genre4);
        //types
        $types1 = new Types();
        $types1->setLibelle('Soleil');
        $manager->persist($types1);
        $types2 = new Types();
        $types2->setLibelle('Vue');
        $types3 = new Types();
        $types3->setLibelle('Sport');
        $manager->persist($types2);
        //fournisseurs
        $fournisseur1 = new Fournisseur();
        $fournisseur1->setSociete('Nike');
        $fournisseur1->setMarque('nike');
        $manager->persist($fournisseur1);
        $fournisseur2 = new Fournisseur();
        $fournisseur2->setSociete('Safilo');
        $fournisseur2->setMarque('safilo');
        $manager->persist($fournisseur2);
        $manager->flush();
        
    }
}