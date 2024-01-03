<?php

namespace App\DTOs;

use Illuminate\Support\Str;

abstract class AbstractDTO
{
    /**
     * @param boolean $snakeCase
     * @return array
     */
    public function toArray(bool $snakeCase = true): array
    {
        $vars =  get_object_vars($this);

        if ($snakeCase) {
            $vars = collect($vars)->mapWithKeys(function ($value, $key) {
                return [Str::snake($key) => $value];
            })->toArray();
        }

        return $vars;
    }
}