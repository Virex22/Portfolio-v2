<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    /**
     * Mapping des balises HTML à remplacer par les classes CSS de Trix
     */
    const TRIXYFY_MAPPING = [
        'strong' => 'trix-bold',
        'em' => 'trix-italic',
        'u' => 'trix-underline',
        'del' => 'trix-strikethrough',
    ];

    public function getFilters(): array
    {
        return [
            new TwigFilter('base64_encode', [$this, 'base64Encode']),
            new TwigFilter('trixify', [$this, 'trixify']),
        ];
    }

    public function base64Encode($string): string
    {
        return base64_encode($string);
    }

    public function trixify($string): string
    {
        // Remplacer les balises HTML par les classes CSS spécifiques de Trix
        foreach (self::TRIXYFY_MAPPING as $tag => $class) {
            $string = preg_replace('/<' . $tag . '>(.*?)<\/' . $tag . '>/', '<span class="' . $class . '">$1</span>', $string);
        }

        return $string;
    }
}