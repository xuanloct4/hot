<?php

namespace Src\Definition;

use MyCLabs\Enum\Enum;

class Comparison extends Enum
{
    const undefine = -1;
    const equal = 0;
    const ascending = 1;
    const descending = 2;
    const unequal = 3;
}