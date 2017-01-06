<?php

namespace Models;

class TableModel extends BaseModel {

    public function saveNewChampion($name, $user, $time)
    {
        $query = $this->link->prepare('insert `result` (`user`, `name`, `time`) values (?, ?, ?)');
        $query->bind_param("sss", $user, $name, $time);

        return $query->execute();
    }

    public function getHallOfFame()
    {
        $data = $this->getTable();
        $result = [];
        while ($row = $data->fetch_object()) {
            $result[$row->id] = [htmlspecialchars($row->name), htmlspecialchars($row->time)];
        }

        return $result;
    }

    private function getTable()
    {
        return $this->link->query('select * from `result` order by `time` ASC limit 50');
    }
}
