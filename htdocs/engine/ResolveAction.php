<?php

class ResolveAction {

    private $allowedActions = ['start', 'turn', 'table'];

    private $request;

    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
    }

    public function resolve()
    {
        $action = $this->request->getOrElse('action');

        if (!$action || !in_array($action, $this->allowedActions)) {
            return new ErrorAction();
        }

        switch ($action) {
            case 'start':
                return new StartAction($this->request);
                break;
            case 'turn':
                return new TurnAction($this->request);
                break;
            case 'table':
                return new TableAction($this->request);
                break;
        }
    }
}
