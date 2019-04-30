<?php
declare (strict_types = 1);

namespace Blog\Factories;

use Blog\Controller\BlogController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Blog\Services\BlogService;
use Doctrine\ORM\EntityManager;

/**
 * Class ControllerFactory
 * @package Blog\Factories
 */
class ControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return BlogController|mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $blogService = $serviceLocator->get(BlogService::class);
        $em=$serviceLocator->get(EntityManager::class);

        return new BlogController($blogService,$em);
    }
}
