<?php

namespace User\Factories;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use User\Controller\UserController;
use Zend\Authentication\AuthenticationService;

/**
 * Class ControllerFactory
 * @package Blog\Factories
 */
class UserControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return BlogController|mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $authService = $serviceLocator->get(AuthenticationService::class);
        
        return new UserController($authService);
    }
}
