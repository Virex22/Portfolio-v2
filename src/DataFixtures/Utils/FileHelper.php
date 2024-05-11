<?php

namespace App\DataFixtures\Utils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHelper
{

    public static function createUploadedFile(string $name): UploadedFile
    {
        copy(
            __DIR__ . '/../../../public/uploads/ph.webp',
            __DIR__ . '/../../../public/uploads/' . $name);
        return new UploadedFile(
            __DIR__ . '/../../../public/uploads/' . $name,
            $name,
            'image/webp',
            null,
            true
        );
    }
}