<?php

class TableModel extends BaseModel {

    public function getHallOfFame()
    {
        $data = $this->getTable();
        $result = [];
        while ($row = $data->fetch_object()) {
            $result[$row->id] = [$row->name, $row->time];
        }

        return $result;
    }

    private function getTable()
    {
        return $this->link->query('select * from `result` order by `time` limit 50');
    }
}
