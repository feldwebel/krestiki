<?php

spl_autoload_register(function ($class) {
    $engine = realpath(__DIR__ ) . '/engine/';
    include $engine . $class . '.php';
    include $engine . 'models/' . $class . '.php';
    include $engine . 'actions/' . $class . '.php';
    include $engine . 'ai/' . $class . '.php';
});

$request = new HttpRequest($_POST);

$action = (new ActionResolver($request))->resolve();

$result = $action->execute($request);

echo $result->make();