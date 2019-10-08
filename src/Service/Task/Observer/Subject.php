<?php

namespace Src\Service\Task\Observer;


use Src\Definition\KeyPath;

class Subject implements \SplSubject
{
    public $identifier;
    public $keyPath;
    private $state;

    /**
     * @var \SplObjectStorage List of subscribers. In real life, the list of
     * subscribers can be stored more comprehensively (categorized by event
     * type, etc.).
     */
    private $observers;

    public function __construct(KeyPath $keyPath)
    {
        $this->observers = new ObjectStorage();
        $this->keyPath = $keyPath;
    }

    /**
     * The subscription management methods.
     */
    public function attach(\SplObserver $observer)
    {
//        echo "Subject: Attached an observer.\n";
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer)
    {
        $this->observers->detach($observer);
//        echo "Subject: Detached an observer.\n";
    }

    /**
     * Trigger an update in each subscriber.
     */
    public function notify()
    {
//        echo "Subject: Notifying observers...\n";
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
        $this->notify();
    }
}