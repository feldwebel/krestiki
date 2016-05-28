<?php

class TurnAction implements IAction {

    public function execute(\HttpRequest $request) {
        $user = $request->getOrElse('user');
        $row = $request->getOrElse('row');
        $col = $request->getOrElse('col');
        $model = new GameModel();

        $position = unserialize($model->getPosition($user));

        if ($position[$row][$col] == 0) {
            $position[$row][$col] = 'x';
        }
        if ($this->checkWin($position)) {
            return 'you win';
        }
        $this->AI($position);
        if ($this->checkWin($position)) {
            return 'you lose';
        }

        $model->savePosition($user, serialize($position));

        return 'next';

    }
}
