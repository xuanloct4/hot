<?php

namespace Src\Service\Task\Observer;



use Src\Definition\KeyPath;

interface iObject {
    public function isBroadcaster();
}

class Object implements \SplObserver
{
    public $identifier;
    public $keyPaths;

    public function update(\SplSubject $subject)
    {
        var_dump($subject);
    }

    public function __construct()
    {
        $this->keyPaths = array();
    }

    public function isKeyExists(KeyPath $key) {
        foreach ($this->keyPaths as $myKey) {
            if (strcmp($myKey,$key) == 0) {
                return true;
            }
        }
        return false;
    }
}