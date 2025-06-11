<?php

namespace App\Enums;

use ReflectionClass;

class PlatformName
{
    public const FACEBOOK = 'facebook';
    public const LINKEDIN = 'linkedin';
    public const TWITTER = 'twitter';
    public const INSTAGRAM = 'instagram';
    public const PINTEREST = 'pinterest';
    public const TIKTOK = 'tiktok';
    public const YOUTUBE = 'youtube';
    public const REDDIT = 'reddit';

    /**
     * Get all platform values.
     *
     * @return array
     */
    public static function getValues(): array
    {
        $reflection = new ReflectionClass(self::class);
        return array_values($reflection->getConstants());
    }

    /**
     * Mimic the ::cases() method of native enums for compatibility.
     * Returns an array of objects, where each object has a 'value' property.
     *
     * @return array
     */
    public static function cases(): array
    {
        $values = self::getValues();
        $cases = [];
        foreach ($values as $value) {
            $case = new \stdClass(); // Create a generic object
            $case->value = $value;
            // If you need a 'name' property like native enums (e.g., 'FACEBOOK' for 'facebook')
            // $constants = (new ReflectionClass(self::class))->getConstants();
            // $case->name = array_search($value, $constants, true);
            $cases[] = $case;
        }
        return $cases;
    }
}
