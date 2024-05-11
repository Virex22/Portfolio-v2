<?php

namespace App\DataFixtures\Entity;

use App\DataFixtures\Utils\FileHelper;
use App\Entity\Skill;
use App\Helper\LocaleHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\VichUploaderBundle;

class SkillFixtures extends Fixture
{
    // need to have more than skillGroupFixtures
    static int $count = 35;

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::$count; $i++) {
            $skill = new Skill();
            $this->setLocaleFields($skill, $i);
            if ($i % 2 === 0) {
                $skill->setBadgeFile(FileHelper::createUploadedFile('skill' . $i . '.webp'));
            }
            $manager->persist($skill);
        }
        $manager->flush();
    }

    private function setLocaleFields(Skill $skill, int $i): void
    {
        $locales = LocaleHelper::getLocales();
        foreach ($locales as $locale) {
            $skill->setTranslatedField('name', 'Skill ' . $i . ' ' . $locale, $locale);
        }
    }
}