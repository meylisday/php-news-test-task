<?php

namespace App\Core;

use App\Helpers\Helpers;
use PDO;

abstract class Model
{
    protected static function getDB()
    {
        $envData = Helpers::parseEnvFile('.env');

        $host = $envData['DB_HOST'];
        $dbname = $envData['DB_DATABASE'];
        $username = $envData['DB_USERNAME'];
        $password = $envData['DB_PASSWORD'];

        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8';
            $db = new PDO($dsn, $username, $password);

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}