<?php

declare(strict_types=1);

namespace App\Actions;

use App\HttpStuff\HttpRequest;
use App\HttpStuff\JsonResponse;
use App\Models\GameModel;

class StartAction implements IAction {

    public function execute(HttpRequest $request): JsonResponse
    {
        $position = $this->getInitPosition();

        (new GameModel())->beginGame($request->getOrElse('user'), $position);

        return new JsonResponse('lets start', $position);
    }

    private function getInitPosition(): array
    {
        $result = [];
        for ($i = 0; $i < 20; $i++) {
            for ($j = 0; $j < 20; $j++) {
                $result[$i][$j] = 0;
            }
        }
        return $result;
    }
}
