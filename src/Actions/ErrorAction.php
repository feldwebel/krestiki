<?php

namespace Actions;

use HttpRequest;
use HttpResponse;

class ErrorAction implements IAction {

    public function execute(HttpRequest $request): HttpResponse
    {
        return new HttpResponse('error');
    }

}
