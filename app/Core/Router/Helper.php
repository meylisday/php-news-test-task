<?php

namespace App\Core\Router;

class Helper
{
    public static function trimPath(string $path): string
    {
        return '/' . rtrim(ltrim(trim($path), '/'), '/');
    }
}
