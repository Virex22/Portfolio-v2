<?php

namespace App\DataFixtures\Entity;

use App\Entity\Configuration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConfigurationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $configuration = new Configuration();
        $configuration->setName('APP_MAINTENANCE');
        $configuration->setValue('false');
        $manager->persist($configuration);
        $manager->flush();
    }
}
