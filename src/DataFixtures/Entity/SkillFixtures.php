<?php

namespace App\DataFixtures\Entity;

use App\Entity\Skill;
use App\Helper\LocaleHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    // need to have more than skillGroupFixtures
    static int $count = 35;

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::$count; $i++) {
            $skill = new Skill();
            $this->setLocaleFields($skill, $i);
            $skill->setBadgeUrl('https://via.placeholder.com/150');
            $manager->persist($skill);
        }
        $manager->flush();
    }

    private function setLocaleFields(Skill $skill, int $i): void
    {
        $locales = LocaleHelper::getLocales();
        foreach ($locales as $locale) {
            $skill->setTranslatedField('name', 'Skill ' . $i . ' ' . $locale, $locale);
            $skill->setTranslatedField('description', 'Description ' . $i . ' ' . $locale, $locale);
        }
    }
}