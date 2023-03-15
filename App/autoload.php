<?php
/**
 * 自动加载类
 */

function LemonUCentre_ClassLoader($class)
{
    $path = str_replace('LemonUCentre\\', '', $class);
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
    $file = __DIR__ . DIRECTORY_SEPARATOR . $path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}
spl_autoload_register('LemonUCentre_ClassLoader');
