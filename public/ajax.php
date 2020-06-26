<?php

include __DIR__ . '/../vendor/autoload.php';

use Actions\ActionResolver;

$request = new HttpRequest($_POST);

$action = (new ActionResolver($request))->resolve();

$result = $action->execute($request);

$result->sendJSON();