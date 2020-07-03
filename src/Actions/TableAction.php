<?php

namespace Actions;

use HttpRequest;
use HttpResponse;
use Models\TableModel;

class TableAction implements IAction {

    public function execute(HttpRequest $request): HttpResponse
    {
        $model = new TableModel();

        if ($request->getOrElse('action') == 'winner') {
            $model->saveNewChampion($request->getOrElse('name'), $request->getOrElse('user'), $request->getOrElse('time'));
        }

        return new HttpResponse('table', $model->getHallOfFame());
    }
}