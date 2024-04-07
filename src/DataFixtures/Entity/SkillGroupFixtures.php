<?php

namespace App\DataFixtures\Entity;

use App\Entity\Skill;
use App\Entity\SkillGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SkillGroupFixtures extends Fixture implements DependentFixtureInterface
{
    static int $count = 15;

    public function getDependencies(): array
    {
        return [
            SkillFixtures::class
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $allSkills = $manager->getRepository(Skill::class)->findAll();
        for ($i = 1; $i <= self::$count; $i++) {
            $skillGroup = new SkillGroup();
            $skillGroup->setPriority($i);
            $skillGroup->setAcquiredPercentage($i * 10);
            if (rand(0, 1) === 1)
                $skillGroup->setCustomName('Custom Name ' . $i);
            // add some skills to the skill group (unique)
            $skillGroup->addSkill(array_pop($allSkills));
            for ($j = 1; $j <= rand(1, 3); $j++)
                if (count($allSkills) > self::$count - $i)
                    $skillGroup->addSkill(array_pop($allSkills));
            $manager->persist($skillGroup);
        }
        $manager->flush();
    }
}