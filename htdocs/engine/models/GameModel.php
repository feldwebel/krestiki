<?php

class GameModel extends BaseModel {

    public function beginGame($user, array $position)
    {
        $result = $this->link->prepare('insert `game` (`user`, `position`) values (?, ?)');
        $serialized = serialize($position);
        $result->bind_param('ss', $user, $serialized);
        $result->execute();

        return $result->error ? null : $result->affected_rows;
    }

    public function getPosition($user) {
        $query = $this->link->prepare('select `position` from `game` where `user` like ?');
        $query->bind_param("s", $user);
        $query->execute();
        $data = $query->get_result();
        $result = $data->fetch_object();

        return unserialize($result->position);
    }

    public function savePosition($user, $position) {
        $query = $this->link->prepare('update `game` set `position` = ? where `user` like ?');
        $serialized = serialize($position);
        $query->bind_param("ss", $serialized, $user);

        return $query->execute();
    }

    public function saveEnd($user)
    {
        $query = $this->link->prepare('update `game` set `end` = NOW() where `user` like ?');
        $query->bind_param("s", $user);

        return $query->execute();
    }

    public function getTimeSpent($user)
    {
        $query = $this->link->prepare('select TIMEDIFF(`end`, `start`) spent from `game` where `user` like ?');
        $query->bind_param('s', $user);
        $query->execute();
        $data = $query->get_result();
        $result = $data->fetch_object();

        return $result->spent;
    }
}
