<?php

namespace Actions;

use HttpRequest;
use HttpResponse;
use Models\GameModel;
use AI\StubAI;
use CellStateEnum;

class TurnAction implements IAction {

    const SIZE = 19;
    const STREAK = 5;

    private $model;

    private $ai;

    public function __construct()
    {
        $this->model = new GameModel();
        $this->ai = new StubAI(self::SIZE);
    }

    public function execute(\HttpRequest $request): HttpResponse
    {
        $user = $request->getOrElse('user');
        $row = $request->getOrElse('row');
        $col = $request->getOrElse('col');

        $position = $this->model->getPosition($user);

        if (CellStateEnum::isFree($position[$row][$col])) {
            $position[$row][$col] = CellStateEnum::USER;
        }

        if ($this->isWin($position, CellStateEnum::USER, $row, $col)) {
            return
                $this->gameOver('you win', $user, $position);
        }

        $position = $this->ai->makeTurn($position);
        if ($this->isWin($position, CellStateEnum::AI, $row, $col)) {
            return
                $this->gameOver('you lose', $user, $position);
        }

        $this->model->savePosition($user, $position);

        return new HttpResponse('next turn', $position);
    }

    /**
     * @param string $message
     * @param string $user
     * @param array $position
     * @return \HttpResponse
     */
    private function gameOver($message, $user, array $position)
    {
        $this->model->savePosition($user, $position);
        $this->model->saveEnd($user);
        $time = $this->model->getTimeSpent($user);
        return new HttpResponse($message, $position, $time);
    }

    /**
     *
     * @param array $position
     * @param string $p
     * @param int $row
     * @param int $col
     * @return boolean
     */
    private function isWin(array $position, $p, $row, $col)
    {
        $streak1 = $streak2 = 0; // + check
        for ($i = 0; $i <= self::SIZE; $i++) {
            $streak1 = ($position[$row][$i] === $p) ? $streak1 + 1 : 0;
            $streak2 = ($position[$i][$col] === $p) ? $streak2 + 1 : 0;
            if ($streak1 == self::STREAK || $streak2 == self::STREAK) return true;
        }

        for ($n = 0; $n <= self::SIZE - self::STREAK; $n++) { // \\\\ check
            $streak1 = $streak2 = 0;
            for ($m = 0; $m <= self::SIZE - $n; $m++) {
                $streak1 = ($position[$m][$m + $n] === $p) ? $streak1 + 1 : 0;
                $streak2 = ($position[$m + $n][$m] === $p) ? $streak2 + 1 : 0;
                if ($streak1 == self::STREAK || $streak2 == self::STREAK) return true;
            }
        }

        for ($n = self::STREAK-1; $n <= self::SIZE; $n++) { // //// check
            $streak1 = $streak2 = 0;
            for ($m = 0; $m <= $n; $m++) {
                $streak1 = ($position[$m][$n - $m] === $p) ? $streak1 + 1 : 0;
                $streak2 = ($position[self::SIZE - $n + $m][self::SIZE - $m] === $p) ? $streak2 + 1 : 0;
                if ($streak1 == self::STREAK || $streak2 == self::STREAK) return true;
            }
        }

        return false;
    }
}
