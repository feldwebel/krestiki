<?php

class TableModel {

    private $link;

    public function __construct()
    {
        $this->link = DB::me()->getLink();
        file_put_contents('log.txt', 'link: '.print_r($this->link, 1));
    }

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
