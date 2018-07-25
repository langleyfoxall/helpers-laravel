<?php

namespace LangleyFoxall\Helpers;

use Illuminate\Database\Eloquent\Model;

abstract class Models
{
    public static function all()
    {
        return collect(get_declared_classes())->filter(function($class) {
            return is_subclass_of($class, Model::class);
        });
    }
}