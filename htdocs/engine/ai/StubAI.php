<?php

class StubAI implements IArtificialIntellect {

    private $width;

    public function __construct($width = 19)
    {
        $this->width = $width;
    }

    public function makeTurn(array $position) {
        $done = false;
        while (!$done) {
            list($row, $col) = $this->generateCell();

            if (CellStateEnum::isFree($position[$row][$col])) {
                $position[$row][$col] = CellStateEnum::AI;
                $done = true;
            }
        }
        return $position;
    }

    /**
     * @return array
     */
    private function generateCell()
    {
        return [rand(0, $this->width), rand(0, $this->width)];
    }
}
