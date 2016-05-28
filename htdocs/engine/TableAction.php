<?php

class TableAction implements IAction {

    public function execute(HttpRequest $request)
    {
        return new HttpResponse('table', (new TableModel())->getHallOfFame());
    }
}