<?php

namespace Actions;

use \HttpRequest;
use \HttpResponse;

interface IAction {

    public function execute(HttpRequest $request): HttpResponse;

}
