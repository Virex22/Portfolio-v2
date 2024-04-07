<?php

namespace App\DataFixtures\Entity;

use App\Entity\Project;
use App\Entity\ProjectContent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Enum\EProjectViewType;

class ProjectContentFixtures extends Fixture implements DependentFixtureInterface
{
    static int $count = 50;

    public function getDependencies(): array
    {
        return [
            ProjectFixtures::class,
        ];
    }

    private function getRandomSizedImage(): string
    {
        $width = rand(400, 800);
        $height = rand(400, 800);
        return "https://via.placeholder.com/{$width}x{$height}";
    }

    public function load(ObjectManager $manager): void
    {
        $allProjects = $manager->getRepository(Project::class)->findAll();

        for ($i = 0; $i < self::$count; $i++) {
            $project = $allProjects[array_rand($allProjects)];
            $projectContent = new ProjectContent();

            $rand4 = rand(1, 4);
            if ($rand4 === 1) {
                $projectContent->setViewType(EProjectViewType::ALL_TEXT);
                $projectContent->setTextContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc tincidunt aliquam. Nullam nec purus nec nunc tincidunt aliquam.');
            } elseif ($rand4 === 2) {
                $projectContent->setViewType(EProjectViewType::ALL_IMAGE);
                $projectContent->setImgUrl($this->getRandomSizedImage());
            } elseif ($rand4 === 3) {
                $projectContent->setViewType(EProjectViewType::IMAGE_LEFT);
                $projectContent->setImgUrl($this->getRandomSizedImage());
                $projectContent->setTextContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc tincidunt aliquam. Nullam nec purus nec nunc tincidunt aliquam.');
            } else {
                $projectContent->setViewType(EProjectViewType::IMAGE_RIGHT);
                $projectContent->setImgUrl($this->getRandomSizedImage());
                $projectContent->setTextContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc tincidunt aliquam. Nullam nec purus nec nunc tincidunt aliquam.');
            }

            $projectContent->setPosition($project->getProjectContents()->count() + 1);
            $project->addProjectContent($projectContent);
            $manager->persist($projectContent);
        }
        $manager->flush();
    }
}