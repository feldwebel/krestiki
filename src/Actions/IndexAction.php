<?php

declare(strict_types=1);

namespace App\Actions;

use App\HttpStuff\HtmlResponse;
use App\HttpStuff\HttpRequest;
use App\HttpStuff\IHttpResponse;

class IndexAction implements IAction
{

    public function execute(HttpRequest $request): IHttpResponse
    {
        return new HtmlResponse('index.php');
    }
}