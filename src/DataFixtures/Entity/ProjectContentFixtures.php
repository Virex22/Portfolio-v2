<?php

namespace App\DataFixtures\Entity;

use App\Entity\Project;
use App\Entity\ProjectContent;
use App\Helper\LocaleHelper;
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
                $this->setLocaleFields($projectContent, $i);
           } elseif ($rand4 === 2) {
                $projectContent->setViewType(EProjectViewType::ALL_IMAGE);
            } elseif ($rand4 === 3) {
                $projectContent->setViewType(EProjectViewType::IMAGE_LEFT);
                $this->setLocaleFields($projectContent, $i);
            } else {
                $projectContent->setViewType(EProjectViewType::IMAGE_RIGHT);
                $this->setLocaleFields($projectContent, $i);
            }

            $projectContent->setPosition($project->getProjectContents()->count() + 1);
            $project->addProjectContent($projectContent);
            $manager->persist($projectContent);
        }
        $manager->flush();
    }

    private function setLocaleFields(ProjectContent $projectContent, int $i): void
    {
        $locales = LocaleHelper::getLocales();
        foreach ($locales as $locale) {
            $projectContent->setTranslatedField('text_content', 'Project Content ' . $i . ' ' . $locale, $locale);
        }
    }
}