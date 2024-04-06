<?php

namespace App\Enum;

class EProjectViewType
{
    public const ALL_TEXT = 'AllText';
    public const ALL_IMAGE = 'AllImage';
    public const IMAGE_LEFT = 'ImageLeft';
    public const IMAGE_RIGHT = 'ImageRight';

    public static function toArray(): array
    {
        return [
            self::ALL_TEXT,
            self::ALL_IMAGE,
            self::IMAGE_LEFT,
            self::IMAGE_RIGHT,
        ];
    }
}