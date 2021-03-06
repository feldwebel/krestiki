<?php

namespace Models;

class TableModel extends BaseModel {

    public function saveNewChampion($name, $user, $time)
    {
        $query = $this->link->prepare('insert into result ("user", "name", "time") values (:user, :name, :time)');
        $query->bindParam(":user", $user);
        $query->bindParam(":name", $name);
        $query->bindParam(":time", $time);

        return $query->execute();
    }

    public function getHallOfFame()
    {
        $data = $this->getTable();
        $data->execute();
        $result = [];
        while ($row = $data->fetch(\PDO::FETCH_LAZY)) {
            $result[$row->id] = [htmlspecialchars($row->name), htmlspecialchars($row->time)];
        }

        return $result;
    }

    private function getTable()
    {
        return $this->link->query('select * from result order by "time" ASC limit 50');
    }
}
