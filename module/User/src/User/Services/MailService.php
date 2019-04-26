<?php

namespace User\Services;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\Mail\Message;
use Zend\Mail\Transport\SmtpOptions;

class MailService implements EventManagerAwareInterface
{

    protected $eventManager;

    public function sendMail($user)
    {
        $message = new Message();
        $message->setBody('Thank you for registering');
        $message->setFrom('Application@app.com');
        $message->addTo($user->getEmail());
        $message->setSubject('Test subject');
        $smtp = new SmtpOptions();
        $smtp->setConnectionClass('crammd5');
        $smtp->setHost('smtp.mailtrap.io');
        $smtp->setPort(2525);
        $smtp->setConnectionConfig(array(
            'username' => 'cc5089803836ef',
            'password' => '8cdee9be21f9b0',
        ));
        $transport = new \Zend\Mail\Transport\Smtp($smtp);
        $transport->send($message);
    }

    /**
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->addIdentifiers(array(
            get_called_class()
        ));

        $this->eventManager = $eventManager;
    }


    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager());
        }

        return $this->eventManager;
    }
}
