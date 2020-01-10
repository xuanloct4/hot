<?php

namespace Src\Controller;

interface iRequest
{
   public function toArray();
}

class Request implements iRequest
{
    public function toArray() {
        return get_object_vars($this);
    }
}
