<?php

class TurnAction implements IAction {

    const WIDTH = 19;
    const HEIGHT = 19;

    public function execute(\HttpRequest $request) {
        $user = $request->getOrElse('user');
        $row = $request->getOrElse('row');
        $col = $request->getOrElse('col');
        $model = new GameModel();

        $position = unserialize($model->getPosition($user));

        if ($position[$row][$col] == 0) {
            $position[$row][$col] = 'x';
        }
        if ($this->checkWin($position, 'x', $row, $col)) {
            $model->saveEnd($user);
            return new HttpResponse('you win', $position);
        }
        $this->AI($position);
        if ($this->checkWin($position, 'o', $row, $col)) {
            $model->saveEnd($user);
            return new HttpResponse('you lose', $position);
        }

        $model->savePosition($user, serialize($position));

        return new HttpResponse('next turn', $position);
    }

    private function checkWin($position, $p, $row, $col)
    {
        $left = ($col - 5) >= 0 ? $col - 5 : 0;
        $right = ($col + 5) <= self::WIDTH ? $col + 5 : self::WIDTH;
        $top = ($row - 5) >= 0 ? $row -5 : 0;
        $bottom = ($row + 5) <= self::HEIGHT ? $row + 5 : self::HEIGHT;

        $streak = 0;
        for ($i = $left; $i <= $right; $i++) {
            $strek = ($position[$row][$i] === $p) ? $streak + 1 : 0;
            if ($streak == 5) return true;
        }

        $streak = 0;
        for ($i = $top; $i <= $bottom; $i++) {
            $streak = $position[$i][$col] === $p ? $streak + 1 : 0;
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
