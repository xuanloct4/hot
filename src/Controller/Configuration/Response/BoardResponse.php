<?php

namespace Src\Controller\Configuration\Response;


use Src\Controller\Response;
use Src\Entity\Board\Board;

class BoardResponse extends Response
{
    public $id;
    public $name;
    public $description;
    public $model;
    public $manufacturer;
    public $version;
    public $firmware;
    public $os;
    public $image;
    public $sensors;
    public $boards;
    public $public_contacts;
    public $internal_contacts;
    public $is_deleted;
    public $is_activated;

    public function __construct(Board $board)
    {
        $this->id = $board->id;
        $this->name = $board->name;
        $this->description = $board->description;
        $this->model = $board->model;
        $this->manufacturer = $board->manufacturer;
        $this->version = $board->version;
        $this->firmware = $board->firmware;
        $this->os = $board->os;
        $this->image = $board->image;
        $this->sensors = $board->sensors;
        $this->boards = $board->boards;
        $this->public_contacts = $board->public_contacts;
        $this->internal_contacts = $board->internal_contacts;
        $this->is_deleted = $board->is_deleted;
        $this->is_activated = $board->is_activated;
    }
}
