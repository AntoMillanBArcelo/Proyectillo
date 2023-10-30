<?php
function myAutoloader($class) 
{
    $classPath = 'classes/' . $class . '.php';
    if (file_exists($classPath)) 
    {
        require_once $classPath;
    }
}

spl_autoload_register('myAutoloader');
