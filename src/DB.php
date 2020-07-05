<?php

declare(strict_types=1);

namespace App;

use PDO;

class DB {

    private static $instance;

    private PDO $link;

    private static array $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public static function me()
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    private function __construct()
    {
        $this->link = new PDO(
            "pgsql:dbname=".getenv('DB_NAME').";host=db",
            getenv('DB_USER'),
            getenv('DB_PASSWORD'),
            self::$opt);
    }

    public function getLink()
    {
        return $this->link;
    }
}
