<?php

use App\Actions\ActionResolver;
use App\HttpStuff\HttpRequest;

include __DIR__ . '/../vendor/autoload.php';

define('ROOT', __DIR__ . '/../src');

$request = new HttpRequest($GLOBALS);

$action = (new ActionResolver($request))->resolve();

$result = $action->execute($request);

$result->render();