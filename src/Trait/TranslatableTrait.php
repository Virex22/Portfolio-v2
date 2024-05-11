<?php

namespace App\Trait;

use App\Attributes\Translatable;
use App\Entity\Translation;
use Doctrine\ORM\EntityManagerInterface;

trait TranslatableTrait
{

    private array $translatedFields = [];

    public function setTranslatedField(string $fieldName, string $value, string $locale): void
    {
        $availableFields = Translatable::getTranslatableFields($this);
        if (!in_array($fieldName, $availableFields)) {
            throw new \InvalidArgumentException("Field $fieldName is not translatable or not exists in " . get_class($this));
        }
        if (!isset($this->translatedFields[$fieldName])) {
            $this->translatedFields[$fieldName] = [];
        }
        $this->translatedFields[$fieldName][$locale] = $value;
    }

    public function getTranslatedField(string $fieldName, string $locale): ?string
    {
        if (!isset($this->translatedFields[$fieldName])) {
            return null;
        }
        return $this->translatedFields[$fieldName][$locale] ?? null;
    }

    public function getAllTranslatedFields(string $fieldName): ?array
    {
        return $this->translatedFields[$fieldName] ?? null;
    }

    public function saveTranslations(EntityManagerInterface $entityManager, string $currentLocale): void
    {
        $availableFields = Translatable::getTranslatableFields($this);
        foreach ($availableFields as $field) {
            if ($this->$field === null || $this->$field === '') {
                continue;
            }
            $translationRepository = $entityManager->getRepository(Translation::class);
            $key = Translatable::getTranslationKey($this, $field);
            $translations = $translationRepository->findBy(['entity_id' => $this->id, 'domain' => $key, 'locale' => $currentLocale]);
            if (empty($translations)) {
                $translation = new Translation();
                $translation->setEntityId($this->id)
                    ->setDomain($key)
                    ->setLocale($currentLocale)
                    ->setValue($this->$field);
                $entityManager->persist($translation);
            } else {
                $translations[0]->setValue($this->$field);
                $entityManager->persist($translations[0]);
            }
        }
        $entityManager->flush();
    }
}