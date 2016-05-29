<?php

class StubAI implements IArtificialIntellect {

    private $width;

    private $aiMarker;

    public function __construct($width = 19, $ai = 'o')
    {
        $this->width = $width;
        $this->aiMarker = $ai;
    }

    public function makeTurn(array $position) {
        $done = false;
        while (!$done) {
            list($row, $col) = $this->generateCell();

            if ($position[$row][$col] == 0) {
                $position[$row][$col] = $this->aiMarker;
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
