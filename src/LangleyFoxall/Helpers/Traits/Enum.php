<?php

namespace LangleyFoxall\Helpers\Traits;

trait Enum
{
    /**
     * Returns an array of all constants defined within the class.
     *
     * @return array
     */
    public static function all(): array
    {
        try {
            $reflection = new \ReflectionClass(self::class);

            return array_values($reflection->getConstants());
        } catch (\ReflectionException $e) {
            // This will never happen as the function can only ever be executed in a context where self::class is valid.
            return [];
        }
    }

    /**
     * Returns a bool indicating whether or not a value is present in the class.
     *
     * @param string $value
     * @return bool
     */
    public static function valid(string $value): bool
    {
        return array_search($value, self::all()) !== false;
    }
}