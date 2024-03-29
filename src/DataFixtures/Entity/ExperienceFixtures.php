<?php

namespace App\DataFixtures\Entity;

use App\Entity\Experience;
use App\Entity\Skill;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class ExperienceFixtures extends Fixture
{
    static int $count = 10;
    public function getDependencies() : array
    {
        return [
            SkillFixtures::class
        ];
    }

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $allSkills = $manager->getRepository(Skill::class)->findAll();
        for ($i = 1; $i <= self::$count; $i++) {
            $experience = new Experience();
            $experience->setCompangyLogoUrl('https://via.placeholder.com/150');
            $experience->setCompagnyName('Compagny ' . $i);
            $experience->setPostName('Post ' . $i);
            $experience->setStartDate(new DateTime('now - ' . $i . ' years'));
            $experience->setEndDate(new DateTime('now - ' . ($i - 1) . ' years'));

            for ($j = 1; $j <= rand(1, 3); $j++)
                if (count($allSkills) > self::$count - $i)
                    $experience->addSkill(array_pop($allSkills));

            $manager->persist($experience);
        }
        $manager->flush();
    }
}