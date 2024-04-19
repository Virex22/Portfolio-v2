<?php

namespace App\Trait;

use App\Attributes\Translatable;

trait TranslatableTrait
{
    private array $translatedFields = [];

    public function setTranslatedField(string $fieldName, string $value, string $locale): void
    {
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
}