<?php

namespace Src\Controller\Updating\Request;


use Src\Controller\Request;

class UpdateConfigurationRequest extends Request
{
    public $id;
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
        $this->id = $arr["id"];
        $this->files = $arr["files"];
        $this->uris = $arr["uris"];
        $this->binary = $arr["binary"];
        $this->strings = $arr["strings"];
        $this->update_order = $arr["update_order"];
        $this->type = $arr["type"];
        $this->scopes = $arr["scopes"];
        $this->category = $arr["category"];
//        if ($arr["is_deleted"] != null) {
            if ($arr["is_deleted"]) {
                $this->is_deleted = 1;
            } else {
                $this->is_deleted = 0;
            }
//        }

//        if ($arr["is_activated"] != null) {
            if ($arr["is_activated"]) {
                $this->is_activated = 1;
            } else {
                $this->is_activated = 0;
            }
//        }
    }
}
