<?php

namespace App\DataFixtures\Entity;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    static int $count = 10;

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::$count; $i++) {
            $service = new Service();
            $service->setName('Service ' . $i);
            $service->setDescription('Description ' . $i);
            $service->setSubtitle('Subtitle ' . $i);
            $service->setPriority($i);
            $manager->persist($service);
        }
        $manager->flush();
    }
}