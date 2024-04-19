<?php

namespace App\DataFixtures\Entity;

use App\Entity\Project;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
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
            $project = new Project();
            $this->setLocaleFields($project, $i);
            $project->setStartDate(new \DateTime('now - ' . $i . ' years'));
            $project->setEndDate(new \DateTime('now - ' . ($i - 1) . ' years - ' . $i . ' days'));

            for ($j = 1; $j <= rand(1, 3); $j++)
                if (count($allSkills) > self::$count - $i)
                    $project->addSkill(array_pop($allSkills));
            $manager->persist($project);
        }
        $manager->flush();
    }

    private function setLocaleFields(Project $project, int $i): void
    {
        $locales = ['en', 'fr'];
        foreach ($locales as $locale) {
            $project->setTranslatedField('name', "Name $i $locale", $locale);
            $project->setTranslatedField('description', "Description $i $locale", $locale);
        }
    }

}