<?php

class TurnAction implements IAction {

    const WIDTH = 19;
    const HEIGHT = 19;

    private $model;

    public function __construct()
    {
        $this->model = new GameModel();
    }

    public function execute(\HttpRequest $request) {
        $user = $request->getOrElse('user');
        $row = $request->getOrElse('row');
        $col = $request->getOrElse('col');


        $position = unserialize($this->model->getPosition($user));

        if ($position[$row][$col] == 0) {
            $position[$row][$col] = 'x';
        }
        if ($this->checkWin($position, 'x', $row, $col)) {
            return
                $this->gameOver('you win', $user, $position);
        }
        $this->AI($position);
        if ($this->checkWin($position, 'o', $row, $col)) {
            return
                $this->gameOver('you lose', $user, $position);
        }

        $this->model->savePosition($user, serialize($position));

        return new HttpResponse('next turn', $position);
    }

    private function gameOver($message, $user, $position)
    {
        $this->model->saveEnd($user, $position);
        $time = $this->model->getTimeSpent($user);
        return new HttpResponse($message, $position, $time);
    }

    private function checkWin($position, $p, $row, $col)
    {
        $left = ($col - 5) >= 0 ? $col - 5 : 0;
        $right = ($col + 5) <= self::WIDTH ? $col + 5 : self::WIDTH;
        $top = ($row - 5) >= 0 ? $row - 5 : 0;
        $bottom = ($row + 5) <= self::HEIGHT ? $row + 5 : self::HEIGHT;

        $streak = 0;
        for ($i = 0; $i <= self::WIDTH; $i++) {
            $streak = ($position[$row][$i] === $p) ? $streak + 1 : 0;
            if ($streak == 5) return true;
        }

        $streak = 0;
        for ($i = 0; $i <= self::HEIGHT; $i++) {
            $streak = ($position[$i][$col] === $p) ? $streak + 1 : 0;
            if ($streak == 5) return true;
        }

        $streak = 0;
        for ($n = 0; $n <= $right - $left; $n++) {
            $streak = ($position[$left+$n][$top+$n] === $p) ? $streak + 1 : 0;
            if ($streak == 5) return true;
        }

        $streak = 0;
        for ($n = 0; $n <= $right - $left; $n++) {
            $streak = ($position[$left+$n][$bottom-$n] === $p) ? $streak + 1: 0;
            if ($streak == 5) return true;
        }

        return false;
    }

    private function AI(array &$position)
    {
        $done = false;
        while (!$done) {
            list($row, $col) = $this->generateCell();

            if ($position[$row][$col] == 0) {
                $position[$row][$col] = 'o';
                $done = true;
            }
        }
    }

    private function generateCell()
    {
        return [rand(0, self::HEIGHT), rand(0, self::WIDTH)];
    }
}
