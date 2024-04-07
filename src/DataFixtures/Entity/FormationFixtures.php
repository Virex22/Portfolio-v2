<?php

namespace App\DataFixtures\Entity;

use App\Entity\Formation;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FormationFixtures extends Fixture implements DependentFixtureInterface
{
    static int $count = 10;

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
            $formation = new Formation();
            $formation->setName('Formation ' . $i);
            $formation->setDescription('Description ' . $i);
            $formation->setStartDate(new \DateTime('2021-01-01'));
            $formation->setEndDate(new \DateTime('2021-12-31'));
            $formation->addSkill(array_pop($allSkills));
            for ($j = 1; $j <= rand(1, 3); $j++)
                if (count($allSkills) > self::$count - $i)
                    $formation->addSkill(array_pop($allSkills));
            $manager->persist($formation);
        }
        $manager->flush();
    }

}