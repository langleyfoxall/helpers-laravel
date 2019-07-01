<?php

namespace LangleyFoxall\Helpers\Traits;

use Illuminate\Support\Str;

/**
 * Trait IdentifiedByUUID.
 */
trait IdentifiedByUUID
{
    /**
     * Boot the trait.
     */
    public static function bootIdentifiedByUUID()
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }
}
