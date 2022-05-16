<?php
declare(strict_types=1);

namespace WymarzonyLogin\TrogloDot;

class EnvLoader
{   
    public static function loadFromFile(string $path): bool
    {
        if (file_exists($path)) {
            $f = file_get_contents($path);
        } else {
            return false;
        }
        
        if (!$f) {
            return false;
        }
        
        $lines = explode(PHP_EOL, $f);
        
        foreach($lines as $line) {
            if (strlen($line) == 0 || $line[0] == "#") {
                continue;
            }
            
            $kv = explode("=", $line);
            if (count($kv) < 2) {
                continue;
            }
            
            $key = trim(array_shift($kv));
            $val = trim(implode("=", $kv), "\"'\t ");
            
            if (strlen($key) == 0 || strlen($val) == 0) {
                continue;
            }
            
            if (!isset($_ENV[$key])) {
                $_ENV[$key] = $val;
            }
            
            if (!isset($_SERVER[$key])) {
                $_SERVER[$key] = $val;
            }
        }
        
        return true;
    }
}