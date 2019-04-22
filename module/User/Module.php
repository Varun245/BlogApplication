<?php

namespace User;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use User\Services\MailService;
use Zend\Mail\Message;
use Zend\Mail\Transport\SmtpOptions;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();

        $sharedEventManager->attach(MailService::class, 'sendMail', function($e) {
            
            $user=$e->getParams();
            $message = new Message();
            $message->setBody('Thank you for registering');
            $message->setFrom('myemail@mydomain.com');
            $message->addTo($user['content']);
            $message->setSubject('Test subject');
            $smtp=new SmtpOptions();
            $smtp->setConnectionClass('crammd5');
            $smtp->setHost('smtp.mailtrap.io');
            $smtp->setPort(2525);
            $smtp->setConnectionConfig(array(
                'username' => 'cc5089803836ef',
                'password' => '8cdee9be21f9b0',
            ));
            $transport = new \Zend\Mail\Transport\Smtp($smtp);
            $transport->send($message);
            
        }, 100);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
