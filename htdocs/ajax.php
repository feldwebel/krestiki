<?php

spl_autoload_register(function ($class) {
    include  realpath(__DIR__ ) . '/engine/' . $class . '.php';
});

$request = new HttpRequest($_POST);

$action = (new ResolveAction($request))->resolve();

$result = $action->execute($request);

echo $result->make();