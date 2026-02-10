<?php
namespace App\Application\School;

final class TextNormalizer
{
    public static function normalize(string $text): string
    {
        $text = mb_strtolower($text);
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^a-z0-9 ]/', '', $text);

        return trim($text);
    }
}
