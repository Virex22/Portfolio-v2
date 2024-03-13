<?php

namespace App\DataFixtures\Entity;

use App\Entity\Skill;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures
{
    static int $count = 10;
    public function getOrder(): int
    {
        return 4;
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::$count; $i++) {
            $skill = new Skill();
            $skill->setName('Skill ' . $i);
            $skill->setDescription('Description ' . $i);
            $skill->setBadgeUrl('https://via.placeholder.com/150');
            $manager->persist($skill);
        }
        $manager->flush();
    }
}