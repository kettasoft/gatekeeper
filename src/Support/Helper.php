<?php

namespace Kettasoft\Gatekeeper\Support;

use InvalidArgumentException;

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
}
