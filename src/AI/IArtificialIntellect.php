<?php

declare(strict_types=1);

namespace App\AI;

interface IArtificialIntellect {

    public function makeTurn(array $position): array;
}
