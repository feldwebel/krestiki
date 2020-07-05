<?php

declare(strict_types=1);

namespace App\Actions;

use App\HttpStuff\HttpRequest;

class ActionResolver {

    private $allowedActions = ['start', 'turn', 'table', 'winner'];

    private $request;

    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
    }

    public function resolve(): IAction
    {
        if ($this->request->isGet()) {
            return new IndexAction();
        }

        $action = $this->request->getOrElse('action');

        if (!$action || !in_array($action, $this->allowedActions)) {
            return new ErrorAction();
        }

        switch ($action) {
            case 'start':
                return new StartAction();
            case 'turn':
                return new TurnAction();
            case 'table':
            case 'winner':
                return new TableAction();
        }
    }
}
