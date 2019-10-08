<?php

namespace Src\Service\Task\Observer;

use Src\Service\Task\iObject;
use Src\Service\Task\Object;

interface iBroadcaster extends iObject
{
    public function post();
    public function attach();
    public function detach();
}

abstract class Broadcaster extends Object implements iBroadcaster
{
    public function isBroadcaster(){
        return true;
    }
}