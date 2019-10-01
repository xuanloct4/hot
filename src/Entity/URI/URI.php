<?php

namespace Src\Entity\URI;

class URI
{
    // table name
    public static $table_name = "uri";

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
