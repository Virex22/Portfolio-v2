<?php

namespace App\DataFixtures\Entity;

use App\Entity\ContactMessage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContactMessageFixtures extends Fixture
{
    static int $count = 5;

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::$count; $i++) {
            $contactMessage = new ContactMessage();
            $contactMessage->setName('Name ' . $i);
            $contactMessage->setEmail('email' . $i . '@example.com');
            $contactMessage->setMessage('Message ' . $i);
            $contactMessage->setSubject('Subject ' . $i);
            $contactMessage->setSurname('Surname ' . $i);
            $contactMessage->setDateAdd(new \DateTime());
            $contactMessage->setDateUpdate(new \DateTime());
            $manager->persist($contactMessage);
        }
        $manager->flush();
    }

}