<?php

declare(strict_types=1);

namespace App\AI;

use App\CellStateEnum;

class StubAI implements IArtificialIntellect {

    private $width;

    public function __construct($width = 19)
    {
        $this->width = $width;
    }

    public function makeTurn(array $position): array {
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

    private function generateCell(): array
    {
        return [rand(0, $this->width), rand(0, $this->width)];
    }
}
