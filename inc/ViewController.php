<?php
function __autoload($class)
{
    $parts = explode('\\', $class);
    require end($parts) . '.php';
}

ini_set('xdebug.max_nesting_level', 200);

$ATM = new ATM\AtmMachine();

$view_data = new ATM\ViewModel($ATM);

$steps = $view_data->display_steps($ATM->recurse());

