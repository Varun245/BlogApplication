<?php

namespace User\Factories;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthorisationServiceFactory implements FactoryInterface {

    protected $authService;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authService = $serviceLocator->get('doctrine.authenticationservice.orm_default');
        
        return $authService;
    }
}
