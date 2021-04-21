<?php

namespace LangleyFoxall\Helpers\Traits;

use Illuminate\Database\Eloquent\Model;
use LangleyFoxall\Helpers\Models;

trait IsRelatedTo
{
    /**
     * Check if the current model is related to a specified model.
     *
     * @param Model|array $relations
     *
     * @throws \InvalidArgumentException|\Exception
     *
     * @return bool
     */
    public function isRelatedTo($model)
    {
        return Models::areRelated($this, $model);
    }
}
