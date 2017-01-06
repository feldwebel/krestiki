<?php

namespace Models;

use DB;

class BaseModel {

    protected $link;

    public function __construct()
    {
        $this->link = DB::me()->getLink();
    }

}
