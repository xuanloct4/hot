<?php

namespace Src\Service\Task\Observer;


use Src\Service\Task\iObject;
use Src\Service\Task\Object;

interface iReceiver extends iObject
{
    public function receive();
    public function attach();
    public function detach();
}

abstract class Receiver extends Object implements iReceiver
{
    public function isBroadcaster(){
        return false;
    }
}