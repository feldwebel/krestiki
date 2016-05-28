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
            return 'you win';
        }
        $this->AI($position);
        if ($this->checkWin($position, 'o', $row, $col)) {
            return 'you lose';
        }

        $model->savePosition($user, serialize($position));

        return json_encode($position);
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
        do{
            list($row, $col) = $this->generateCell();

            if ($position[$row][$col] == 0) {
                $position[$row][$col] = 'o';
            }
        } while ($position[$row][$col] == 'o');
    }

    private function generateCell()
    {
        return [rand(0, self::HEIGHT), rand(0, self::WIDTH)];
    }
}
