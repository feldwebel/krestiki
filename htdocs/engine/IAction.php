<?php

interface IAction {

    /**
     * @param HttpRequest $request
     * @return HttpResponse
     */
    public function execute(HttpRequest $request);
}
