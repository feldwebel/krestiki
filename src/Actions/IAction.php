<?php

declare(strict_types=1);

namespace App\Actions;

use App\HttpStuff\HttpRequest;
use App\HttpStuff\IHttpResponse;


interface IAction {

    public function execute(HttpRequest $request): IHttpResponse;

}
