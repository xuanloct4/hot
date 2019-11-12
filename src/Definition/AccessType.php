<?php


namespace Src\Definition;


use MyCLabs\Enum\Enum;

class AccessType extends Enum
{
    const AUTHORIZED = "authorization";
    const NOT_AUTHORIZED = "no-authorization";
    const TRUSTED_AUTHORIZE = "trusted-authorization";
}
