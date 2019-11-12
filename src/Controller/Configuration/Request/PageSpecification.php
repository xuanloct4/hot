<?php

namespace Src\Controller\Configuration\Request;


class PageSpecification
{
    public $page;
    public $page_size;

    public function __construct($arr)
    {
        $this->page = $arr["page"];
        $this->page_size = $arr["page_size"];
    }
}
