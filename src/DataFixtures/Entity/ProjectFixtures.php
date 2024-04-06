<?php

namespace App\DataFixtures\Entity;

use App\Entity\Project;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture
{
    static int $count = 10;

    public function getDependencies() : array
    {
        return [
            SkillFixtures::class
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $allSkills = $manager->getRepository(Skill::class)->findAll();
        for ($i = 1; $i <= self::$count; $i++) {
            $project = new Project();
            $project->setName('Project ' . $i);
            $project->setDescription('Description ' . $i);
            $project->setContent('Content ' . $i);
            $project->setStartDate(new \DateTime('now - ' . $i . ' years'));
            $project->setEndDate(new \DateTime('now - ' . ($i - 1) . ' years - ' . $i . ' days'));

            for ($j = 1; $j <= rand(1, 3); $j++)
                if (count($allSkills) > self::$count - $i)
                    $project->addSkill(array_pop($allSkills));
            $manager->persist($project);
        }
        $manager->flush();
    }

}