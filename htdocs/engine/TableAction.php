<?php

class TableAction implements IAction {

    public function execute(HttpRequest $request) {
        return
            $this->parse((new TableModel())->getHallOfFame());
    }

    private function parse(array $data)
    {
        return json_encode($data);
    }
}