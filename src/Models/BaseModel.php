<?php

declare(strict_types=1);

namespace App\Models;

use App\DB;

class BaseModel {

    protected $link;

    public function __construct()
    {
        $this->link = DB::me()->getLink();
    }

}
