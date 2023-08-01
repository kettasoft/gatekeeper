<?php

namespace Kettasoft\Gatekeeper\Support;

use InvalidArgumentException;
use Illuminate\Support\Collection;

class Helper
{
    /**
     * Get the id of the given object, string, int, array.
     */
    public static function getIdFor(mixed $object, string $type): int|string|null
    {
        if (is_object($object)) {
            return $object->getKey();
        }

        if (is_array($object)) {
            return $object['id'];
        }

        if (is_numeric($object)) {
            return $object;
        }

        if (is_string($object)) {
            return call_user_func_array([
                config("gatekeeper.models.{$type}"), 'where'
            ], ['name', $object])->firstOrFail()->getKey();
        }

        throw new InvalidArgumentException(
            'getIdFor function only supports Model, array{id: string}, int, string'
        );
    }

    /**
     * Checks if the string passed contains a pipe '|' and explodes the string to an array.
     *
     * @param string|array $value
     * @param boolean $toArray
     * @return string|array
     */
    public static function standardize(string|array $value, bool $toArray = false): string|array
    {
        if (is_string($value) && (strpos($value, '|') === false) && !$toArray) {
            return $value;
        }

        return explode('|', $value);
    }
}
