<?php

namespace Src\Entity\URI;

use Src\Entity\Entity;

class URI extends Entity
{
    // table name
    public static function table()
    {
        return "uri";
    }
    // table columns
    public $id;
    public $representation;
    public $content;
    public $virtual_address;
    public $physical_address;
    public $authorized_id;
    public $scopes;
    public $type;

    public function __construct()
    {

    }
}
