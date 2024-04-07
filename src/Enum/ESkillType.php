<?php

namespace App\Enum;

class ESkillType
{
    public const TECH_SKILL = 'technical';
    public const SOFT_SKILL = 'soft';

    public static function toArray(): array
    {
        return [
            self::TECH_SKILL,
            self::SOFT_SKILL,
        ];
    }
}