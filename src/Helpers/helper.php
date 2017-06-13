<?php
use Bilan\Micro\Micro;


if (! function_exists('tapQuery')) {
    function tapQuery ($value) {
        return $value ? $value : '';
    }
}

/**
 * Реализация краткого обращения к классу Micro
 */
if (! function_exists('micro')) {
    function micro($name = null)
    {
        $app = Micro::getInstance();
        return $name === null ? $app : $app->get($name);
    }
}