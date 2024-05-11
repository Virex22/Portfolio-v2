<?php

namespace App\DataFixtures\Entity;

use App\Entity\Service;
use App\Helper\LocaleHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    static int $count = 10;

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::$count; $i++) {
            $service = new Service();
            $this->setLocaleFields($service, $i);
            $service->setPriority($i);
            $manager->persist($service);
        }
        $manager->flush();
    }

    private function setLocaleFields(Service $service, int $i): void
    {
        $locales = LocaleHelper::getLocales();
        foreach ($locales as $locale) {
            $service->setTranslatedField('name', 'Service ' . $i . ' ' . $locale, $locale);
            $service->setTranslatedField('description', 'Service ' . $i . ' description ' . $locale, $locale);
            $service->setTranslatedField('subtitle', 'Service ' . $i . ' subtitle ' . $locale, $locale);
        }
    }
}