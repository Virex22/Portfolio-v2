<?php

namespace App\Interface;

interface ITranslatable
{
    public function setTranslatedField(string $fieldName, string $value, string $locale): void;
}