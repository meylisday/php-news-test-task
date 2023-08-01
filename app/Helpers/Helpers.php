<?php
namespace App\Helpers;

class Helpers {
    public static function parseEnvFile($filePath): array
    {
        $content = file_get_contents($filePath);
        $lines = explode("\n", $content);
        $envData = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line) && str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $envData[$key] = $value;
            }
        }
        return $envData;
    }
}