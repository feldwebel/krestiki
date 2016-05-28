<?php

class GameModel extends BaseModel {

    public function beginGame($user, $position)
    {
        $result = $this->link->prepare('insert `game` (`user`, `position`) values (?, ?)');
        $result->bind_param('ss', $user, $position);
        $result->execute();

        return $result->error ? null : $result->affected_rows;
    }

    public function getPosition($user) {
        $query = $this->link->prepare('select `position` from `game` where `user` like ?');
        $query->bind_param("s", $user);
        $query->execute();
        $data = $query->get_result();
        $result = $data->fetch_object();

        return $result->position;
    }

    public function savePosition($user, $position) {
        $query = $this->link->prepare('update `game` set `position` = ? where `user` like ?');
        $query->bind_param("ss", $position, $user);
        $query->execute();

        $data = $query->get_result();

        return $data->affected_rows == 1;
    }

    public function saveEnd($user)
    {
        $query = $this->link->prepare('update `game` set `end` = NOW() where `user` like ?');
        $query->bind_param("s", $user);
        $query->execute();

        $data = $query->get_result();

        return $data->affected_rows == 1;
    }
}
