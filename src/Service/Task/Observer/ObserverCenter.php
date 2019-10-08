<?php

namespace Src\Service\Task\Observer;


use Src\Definition\KeyPath;
use Src\Utils\StringUtils;

class ObserverCenter
{
    // Hold the class instance.
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        $this->subjects = array();
        $this->objects = array();
        $this->observerKeyPath = ObserverKeyPath::getInstance();
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ObserverCenter();
        }

        return self::$instance;
    }

    public $subjects;
    public $objects;
    public $observerKeyPath;

    public function addSubject(Subject $subject)
    {
        if (!($this->observerKeyPath->isKeyExists($subject->keyPath))) {
            $this->observerKeyPath->addKey($subject->keyPath);
            array_push($this->subjects, $subject);
        }
    }

    public function addObject(Object $object)
    {
        for ($i = 0; $i < sizeof($object->keyPaths); $i++) {
            $keyPath = $object->keyPaths[$i];
            if ($this->observerKeyPath->isKeyExists($keyPath)) {
                break;
            } else if (!($this->observerKeyPath->isKeyExists($keyPath)) && $i == sizeof($object->keyPaths)-1) {
                $subject = new Subject($keyPath);
                $this->observerKeyPath->addKey($subject->keyPath);
                array_push($this->subjects, $subject);
            }
        }

        array_push($this->objects, $object);

    }

    public function getBroadcasters(Subject $subject=null)
    {
        $arr = array();
        $key = $subject->keyPath;
        foreach ($this->objects as $object) {
            if ($object->isBroadcaster()) {
                if($key == null || ($key != null && $object->isKeyExists($key))) {
                    array_push($arr, $object);
                }
            }
        }
        return $arr;
    }

    public function getReceivers(Subject $subject=null)
    {
        $arr = array();
        $key = $subject->keyPath;
        foreach ($this->objects as $object) {
            if (!($object->isBroadcaster())) {
                if($key == null || ($key != null && $object->isKeyExists($key))) {
                    array_push($arr, $object);
                }
            }
        }
        return $arr;
    }
}

