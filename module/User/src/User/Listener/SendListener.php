<?php

namespace User\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use User\Services\MailService;

class SendListener implements ListenerAggregateInterface
{

    protected $listeners;

    public function attach(\Zend\EventManager\EventManagerInterface $events)
    {
        $sharedEvents = $events->getSharedManager();
        $this->listeners = $sharedEvents()->attach(MailService::class, 'sendMail');
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}
