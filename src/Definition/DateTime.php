<?php

namespace Src\Definition;
use MyCLabs\Enum\Enum;

class DateTime extends Enum
{
    const StandardFormat = "Y-m-d H:i:s.u";
    const DateStandardFormat = "Y-m-d";
    const TimeStandardFormat = "H:i:s.u";
}