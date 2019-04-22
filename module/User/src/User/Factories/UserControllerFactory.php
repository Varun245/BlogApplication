<?php

namespace User\Factories;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use User\Controller\UserController;
use Zend\Authentication\AuthenticationService;
use DoctrineORMModule\Options\EntityManager;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use User\Services\MailService;

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
        $em=$serviceLocator->get(DoctrineEntityManager::class);
        $mailService=$serviceLocator->get(MailService::class);
        
        return new UserController($authService,$em,$mailService);
    }
}
