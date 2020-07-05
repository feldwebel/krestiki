<?php

declare(strict_types=1);

namespace App;

class CellStateEnum {

    const
        FREE = '0',
        USER = 'x',
        AI = 'o';

    public static function isFree($cell)
    {
        return $cell == self::FREE;
    }
}
