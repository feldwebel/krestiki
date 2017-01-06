<?php

namespace AI;

interface IArtificialIntellect {

    /**
     * @param array $position
     * @return array
     */
    public function makeTurn(array $position);
}
