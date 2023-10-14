<?php

function autoload($class)
{
    $dir = str_replace('\\', "/", $class) . ".php";
    if (!file_exists($dir)) {
        throw new Exception("Error al cargar la clase: " . $dir .", verifique");
    } else {
        require_once($dir);
    }
}

spl_autoload_register('autoload');

?>
