<?php

declare(strict_types=1);

namespace App\Actions;

use App\HttpStuff\HttpRequest;
use App\HttpStuff\JsonResponse;

class ErrorAction implements IAction {

    public function execute(HttpRequest $request): JsonResponse
    {
        return new JsonResponse('error');
    }

}
