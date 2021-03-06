<?php
declare(strict_types=1);

namespace Blog\Services;

use Blog\Repositories\BlogRepository;
use Blog\Contracts\BlogServiceInterface;
use Blog\Entity\Blog;

/**
 * Class BlogService
 * @package Blog\Services
 */
class BlogService implements BlogServiceInterface
{
   protected $blogRepository;

    /**
     * BlogService constructor.
     * @param BlogRepository $blogRepository
     */
   public function __construct(BlogRepository $blogRepository)
   {
      $this->blogRepository = $blogRepository;
   }

    /**
     * @return array
     */
   public function findAllBlogs():array
   {
      return $this->blogRepository->findAllBlogs();
   }

    /**
     * @param Blog $blog
     * @return mixed|void
     * @throws \Doctrine\ORM\OptimisticLockException
     */
   public function add(Blog $blog)
   {
       $this->blogRepository->add($blog);
   }

    /**
     * @return mixed|void
     * @throws \Doctrine\ORM\OptimisticLockException
     */
   public function edit()
   {
      $this->blogRepository->edit();
   }

    /**
     * @param Blog $blog
     * @return mixed|void
     * @throws \Doctrine\ORM\OptimisticLockException
     */
   public function delete(Blog $blog)
   {
      $this->blogRepository->delete($blog);
   }

    /**
     * @param int $id
     * @return Blog
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
   public function findById(int $id):Blog
   {
      $blog = $this->blogRepository->findById($id);

      return $blog;
   }
}

