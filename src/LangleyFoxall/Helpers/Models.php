<?php

namespace LangleyFoxall\Helpers;

use Illuminate\Database\Eloquent\Model;

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
     * @param $file
     * @return string
     */
    private static function convertFileToClass($file)
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
}