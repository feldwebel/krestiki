<?php

namespace Models;

class GameModel extends BaseModel {

    public function beginGame($user, array $position)
    {
        $result = $this->link->prepare('insert into game ("user", position) values (:user, :position)');
        $serialized = serialize($position);
        $result->bindParam(':user', $user);
        $result->bindParam(':position', $serialized);
        return $result->execute();
    }

    public function getPosition($user) {
        $query = $this->link->prepare('select position from game where "user" like :user');
        $query->bindValue(':user', "%{$user}%");
        $query->execute();
        $result = $query->fetchColumn();

        return unserialize($result);
    }

    public function savePosition($user, $position) {
        $query = $this->link->prepare('update game set position = :position where "user" like :user');
        $serialized = serialize($position);
        $query->bindParam(":position", $serialized);
        $query->bindValue(':user', "%{$user}%");

        return $query->execute();
    }

    public function saveEnd($user)
    {
        $query = $this->link->prepare('update game set "end" = NOW() where "user" like :user');
        $query->bindValue(':user', "%{$user}%");

        return $query->execute();
    }

    public function getTimeSpent($user)
    {
        $query = $this->link->prepare('select age("end", "start") spent from game where "user" like :user');
        $query->bindValue(':user', "%{$user}%");
        $query->execute();
        $result = $query->fetchColumn();

        return $result;
    }
}
