<?php

namespace App\Trait;

use App\Entity\Skill;
use App\Helper\LocaleHelper;
use App\Manager\CustomTranslationManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

trait CrudTranslatableTrait
{
    private RequestStack $requestStack;

    public function translateInit(RequestStack $requestStack): void
    {
        $this->requestStack = $requestStack;
        CustomTranslationManager::getInstance()->setActive(false);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityManager->persist($entityInstance);
        $entityManager->flush();
        $this->persistTranslatedFields($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->persistTranslatedFields($entityManager, $entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function persistTranslatedFields(EntityManagerInterface $entityManager, object $entityInstance): void
    {
        $currentLocale = LocaleHelper::getLocales()[0];
        if ($this->requestStack->getCurrentRequest()) {
            $currentLocale = $this->requestStack->getCurrentRequest()->getLocale();
        }

        $entityInstance->saveTranslations($entityManager, $currentLocale);
    }
}