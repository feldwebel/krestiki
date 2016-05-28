<?php

class GameModel extends BaseModel {

    public function beginGame($user, $position)
    {
        $result = $this->link->prepare('insert `game` (`user`, `position`) values (?, ?)');
        $result->bind_param('ss', $user, $position);
        $result->execute();

        file_put_contents('log.txt', print_r($result->error, 1));

        return $result->error ? null : $result->affected_rows;
    }

    public function getPosition($user) {
        $result = $this->link->prepare('select * from `game` where `user` = ?');
        $result->bind_param("s", $user);
        $data = $result->execute()->fetch_object;

        return $data->position;
    }

    public function savePosition($user, $position) {

    }
}
