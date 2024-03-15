<?php

namespace App\DataFixtures\Entity;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    // need to have more than skillGroupFixtures
    static int $count = 20;

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