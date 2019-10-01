<?php
namespace Src\Definition;
use MyCLabs\Enum\Enum;

/**
 * Configuarion enum
 */
class Configuration extends Enum
{
    const BOARD = 0;
    const USER = 1;
    const USER_DEVICE = 2;
    const SERVER = 3;
}