<?php

class DB {

    private static $instance = null;

    private $link;

    public static function me()
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    private function __construct()
    {
        $this->link = new mysqli('localhost', 'admin', 'password', 'krestiki_dev');
    }

    public function getLink()
    {
        return $this->link;
    }
}
