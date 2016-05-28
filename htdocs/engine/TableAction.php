<?php

class TableAction implements IAction {

    public function execute(HttpRequest $request)
    {
        $model = new TableModel();

        if ($request->getOrElse('action') == 'winner') {
            $model->saveNewChampion($request->getOrElse('name'), $request->getOrElse('user'), $request->getOrElse('time'));
        }

        return new HttpResponse('table', $model->getHallOfFame());
    }
}