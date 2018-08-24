<?php

namespace LangleyFoxall\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

/**
 * Class Models
 * @package LangleyFoxall\Helpers
 */
abstract class Models
{
    /**
     * Returns a collection of class names for all Eloquent models within your app path.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all()
    {
        $command = 'grep --include="*.php" --files-with-matches -r "class" '.app_path();

        exec($command, $files);

        return collect($files)->map(function($file) {
            return self::convertFileToClass($file);
        })->filter(function($class) {
            return class_exists($class) && is_subclass_of($class, Model::class);
        });
    }

    /**
     * Converts a file name to a namespaced class name.
     *
     * @param string $file
     * @return string
     */
    private static function convertFileToClass(string $file)
    {
        $fh = fopen($file, 'r');

        $namespace = '';

        while(($line = fgets($fh, 5000)) !== false) {

            if (str_contains($line, 'namespace')) {
                $namespace = trim(str_replace(['namespace', ';'], '', $line));
                break;
            }
        }

        fclose($fh);

        $class = basename(str_replace('.php', '', $file));

        return $namespace.'\\'.$class;
    }

    /**
     * UTF-8 encodes the attributes of a model.
     *
     * @param Model $model
     * @return Model
     */
    public static function utf8EncodeModel(Model $model)
    {
        foreach($model->toArray() as $key => $value) {
            if (is_numeric($value) || !is_string($value)) {
                continue;
            }
            $model->$key = utf8_encode($value);
        }

        return $model;
    }

    /**
     * UTF-8 encodes the attributes of a collection of models.
     *
     * @param Collection $models
     * @return Collection
     */
    public static function utf8EncodeModels(Collection $models)
    {
        return $models->map(function($model) {
            return self::utf8EncodeModel($model);
        });
    }

    /**
     * Gets an array of the columns in this model's database table
     *
     * @param Model $model
     * @return mixed
     */
    public static function getColumns(Model $model)
    {
        return Schema::getColumnListing($model->getTable());
    }
}