<?php
declare (strict_types = 1);

namespace Blog\Factories;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Blog\Repositories\BlogRepository;

/**
 * Class BlogRepositoryFactory
 * @package Blog\Factories
 */
class BlogRepositoryFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return BlogRepository|mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');

        return new BlogRepository($em);
    }
}
