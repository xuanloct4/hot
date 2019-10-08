<?php

namespace Src\Service\Task\Observer;


class ObjectStorage extends \SplObjectStorage
{

    private $objInfoMapping = array();

    public function attach($object, $data = null)
    {
        if (null !== $data) {
            $this->objInfoMapping[$data] = $object;
        }
        parent::attach($object, $data);
    }

    public function detach($object)
    {
        $this->detach($object);
        parent::detach($object);
    }

    public function addAll($storage)
    {
        $this->addStorage($storage);

        parent::addAll($storage);
    }

    public function removeAll($storage)
    {
        $this->objInfoMapping = array();
        parent::removeAll($storage);
    }

    public function removeAllExcept($storage)
    {
        $this->objInfoMapping = array();
        $this->addStorage($storage);
        parent::removeAllExcept($storage);
    }

    public function unserialize($serialized)
    {
        parent::unserialize($serialized);
        $this->addStorage($this);
    }

    public function offsetUnset($object)
    {
        $this->detach($object);
        parent::offsetUnset($object);
    }

    protected function detachObject($obj)
    {
        $info = $this[$obj];
        if (array_key_exists($info, $this->objInfoMapping)) {
            unset($this->objInfoMapping[$info]);
        }
    }

    protected function addStorage(SplObjectStorage $storage)
    {
        $storage->rewind();
        while ($storage->valid()) {
            $object = $storage->current(); // similar to current($s)
            $data = $storage->getInfo();
            $this->objInfoMapping[$data] = $object;
            $storage->next();
        }
    }

    public function getClientWithInfo($info)
    {
        if (array_key_exists($info, $this->objInfoMapping)) {
            return $this->objInfoMapping[$info];
        }
    }

}