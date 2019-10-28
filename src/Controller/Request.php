<?php

namespace Src\Controller;

interface iRequest
{
    function toArray();
}

abstract class Request implements iRequest
{
    function toArray() {
        return get_object_vars($this);
    }
}
