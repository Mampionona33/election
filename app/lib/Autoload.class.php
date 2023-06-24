<?php

namespace lib;

/**
 * Cette classe permet de charger les classes automatiquement 
 * sans les appeler à chaque utilisation. Elle devrait être 
 * utilisée comme argument de la fonction spl_autoload_register
 * spl_autoload_register([$autoload, 'loadClass']);
 */
class Autoload
{
    public function loadClass($className)
    {
        $file = dirname(__DIR__) . '/' . str_replace('\\', '/', $className) . '.class.php';

        if (file_exists($file)) {
            require_once $file;
        } else {
            echo $className . " not exist";
        }
    }
}
