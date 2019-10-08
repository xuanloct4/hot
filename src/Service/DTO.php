<?php

namespace Src\Service;

interface iDTO {
    public function toArray();
}

abstract class DTO implements iDTO
{
    public function toString() {
        $arr = $this->toArray();
        return json_encode($arr);
    }
}