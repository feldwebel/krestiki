<?php

class TableAction implements IAction {

    public function execute(HttpRequest $request) {
        $model = new TableModel();

        return
            $this->parse($model->getHallOfFame());
    }

    private function parse(array $data)
    {
        return json_encode($data);
    }
}