<?php

use Illuminate\Support\Collection;

if (! function_exists('standardize')) {

    /**
     * Checks if the string passed contains a pipe '|' and explodes the string to an array.
     *
     * @param string|array $value
     * @param boolean $toArray
     * @return string|array
     */
    function standardize(string|array $value, bool $toArray = false): string|array
    {
        if (is_array($value)) {
            return Collection::make($value)->map(function ($item) {
                return $item instanceof BackedEnum
                    ? $item->value
                    : $item;
            })->toArray();
        }

        if ((strpos($value, '|') === false) && ! $toArray) {
            return $value;
        }

        return explode('|', $value);
    }
}
