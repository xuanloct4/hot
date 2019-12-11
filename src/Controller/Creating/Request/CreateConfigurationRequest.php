<?php

namespace Src\Controller\Creating\Request;


use Src\Controller\Request;

class CreateConfigurationRequest extends Request
{
    public $files;
    public $uris;
    public $binary;
    public $strings;
    public $update_order;
    public $type;
    public $scopes;
    public $category;
    public $is_deleted;
    public $is_activated;

    public function __construct($arr)
    {
        $this->files = $arr["files"];
        $this->uris = $arr["uris"];
        $this->binary = $arr["binary"];
        $this->strings = $arr["strings"];
        $this->update_order = $arr["update_order"];
        $this->type = $arr["type"];
        $this->scopes = $arr["scopes"];
        $this->category = $arr["category"];
        $this->is_activated = b'1';
        $this->is_deleted = b'0';
    }
}
