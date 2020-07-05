<?php

declare(strict_types=1);

namespace App\Actions;

use App\HttpStuff\HttpRequest;
use App\HttpStuff\JsonResponse;
use App\Models\TableModel;

class TableAction implements IAction {

    public function execute(HttpRequest $request): JsonResponse
    {
        $model = new TableModel();

        if ($request->getOrElse('action') == 'winner') {
            $model->saveNewChampion($request->getOrElse('name'), $request->getOrElse('user'), $request->getOrElse('time'));
        }

        return new JsonResponse('table', $model->getHallOfFame());
    }
}