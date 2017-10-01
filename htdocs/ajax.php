<?php

include __DIR__ . '/../vendor/autoload.php';

use Actions\ActionResolver;
use HttpRequest;

$request = new HttpRequest($_POST);

$action = (new ActionResolver($request))->resolve();

$result = $action->execute($request);

$result->sendJSON();