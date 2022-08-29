<?php

namespace App\DataFixtures;

use App\Entity\NewsletterNames;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 5; $i++) {
            $newsletter = new NewsletterNames();
            $newsletter->setName('Newsletter '.$i);
            $manager->persist($newsletter);
        }

        $manager->flush();
    }
}
