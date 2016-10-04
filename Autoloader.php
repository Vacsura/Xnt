<?php
namespace Xnt;

class AutoLoader
{
    public static function register()
    {
        spl_autoload_register('\Xnt\AutoLoader::load');
    }

    private static function load($className)
    {
        $fileName = '';

        if ($className[0] === '\\') {
            $className = substr($className, 1);
        }
        if (substr($className, 0, strlen('Xnt\\')) === 'Xnt\\') {
            $className = substr($className, strlen('Xnt'));
            $fileName = __DIR__ . str_replace('\\', '/', $className) . '.php';
            if (file_exists($fileName)) {
                require_once $fileName;
            }
        }
    }
}

