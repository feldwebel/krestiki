<?php

class ErrorAction implements IAction {

    public function execute(\HttpRequest $request) {
        return 'error happens';
    }
}
