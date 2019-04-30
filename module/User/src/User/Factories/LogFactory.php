<?php

namespace User\Factories;

use Zend\ServiceManager\FactoryInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LogFactory implements FactoryInterface{

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $logger = new Logger('Users');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/app.log', Logger::DEBUG));
        
        return $logger;
    }

}

