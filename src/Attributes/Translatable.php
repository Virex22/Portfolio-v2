<?php

namespace App\Attributes;

use Attribute;
use ReflectionClass;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Translatable
{
    public function __construct(public string $key)
    {
    }
    static function isTranslatableEntity($entity): bool
    {
        $reflectionClass = new ReflectionClass($entity);
        foreach ($reflectionClass->getProperties() as $property) {
            if ($property->getAttributes(Translatable::class)) {
                return true;
            }
        }
        return false;
    }

    static function getTranslatableFields($entity): array
    {
        $reflectionClass = new ReflectionClass($entity);
        $translatableFields = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $translatable = $property;
            if ($translatable->getAttributes(Translatable::class)) {
                $translatableFields[] = $translatable->getName();
            }
        }
        return $translatableFields;
    }

    static function getTranslationKey(object $entity, string $fieldName): string
    {
        $reflectionClass = new ReflectionClass($entity);
        $property = $reflectionClass->getProperty($fieldName);
        $attributes = $property->getAttributes(Translatable::class);
        if (!empty($attributes)) {
            return $attributes[0]->getArguments()['key'] ?? '';
        }
        return '';
    }

}