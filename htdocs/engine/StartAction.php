<?php

class StartAction implements IAction {

    public function execute(HttpRequest $request) {
        return $request->getOrElse('action');
    }
}
