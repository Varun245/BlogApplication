<?php
declare (strict_types = 1);

namespace Blog\Factories;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Blog\Services\BlogService;
use Blog\Repositories\BlogRepository;

/**
 * Class BlogServiceFactory
 * @package Blog\Factories
 */
class BlogServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return BlogService|mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $blogRepository = $serviceLocator->get(BlogRepository::class);

        return new BlogService($blogRepository);
    }
}
