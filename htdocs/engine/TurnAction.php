<?php

class TurnAction implements IAction {

    const SIZE = 19;
    const STREAK = 5;
    const PLAYER = 'x';
    const AI = 'o';

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
            $position[$row][$col] = self::PLAYER;
        }
        if ($this->checkWin($position, self::PLAYER, $row, $col)) {
            return
                $this->gameOver('you win', $user, $position);
        }
        $this->AI($position);
        if ($this->checkWin($position, self::AI, $row, $col)) {
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
        $streak = 0;
        for ($i = 0; $i <= self::SIZE; $i++) {
            $streak = ($position[$row][$i] === $p) ? $streak + 1 : 0;
            if ($streak == 5) return true;
        }

        $streak = 0;
        for ($i = 0; $i <= self::SIZE; $i++) {
            $streak = ($position[$i][$col] === $p) ? $streak + 1 : 0;
            if ($streak == 5) return true;
        }

        for ($n = 0; $n <= self::SIZE - self::STREAK; $n++) {
            $streak1 = $streak2 = 0;
            for ($m = 0; $m <= self::SIZE - $n; $m++) {
                $streak1 = ($position[$m][$m + $n] === $p) ? $streak1 + 1 : 0;
                $streak2 = ($position[$m + $n][$m] === $p) ? $streak2 + 1 : 0;
                if ($streak1 == self::STREAK || $streak2 == self::STREAK) return true;
            }
        }

        for ($n = self::STREAK-1; $n <= self::SIZE; $n++) {
            $streak1 = $streak2 = 0;
            for ($m = 0; $m <= $n; $m++) {
                $streak1 = ($position[$m][$n - $m] === $p) ? $streak1 + 1 : 0;
                $streak2 = ($position[self::SIZE - $n + $m][self::SIZE - $m] === $p) ? $streak2 + 1 : 0;
                if ($streak1 == self::STREAK || $streak2 == self::STREAK) return true;
            }
        }

        return false;
    }

    private function AI(array &$position)
    {
        $done = false;
        while (!$done) {
            list($row, $col) = $this->generateCell();

            if ($position[$row][$col] == 0) {
                $position[$row][$col] = self::AI;
                $done = true;
            }
        }
    }

    private function generateCell()
    {
        return [rand(0, self::SIZE), rand(0, self::SIZE)];
    }
}
