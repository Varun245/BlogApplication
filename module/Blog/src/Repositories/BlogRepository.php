<?php
declare(strict_types=1);

namespace Blog\Repositories;

use Blog\Entity\Blog;
use Doctrine\ORM\EntityManager;
use User\Entity\User;

/**
 * Class BlogRepository
 * @package Blog\Repositories
 */
class BlogRepository
{
    protected $em;

    /**
     * BlogRepository constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function findAllBlogs(): array
    {
        $user=$this->em->find(User::class,1);
        $blogs=$user->getBlogs()->toArray();
     
        $blogs = $this->em->getRepository(Blog::class)->findAll();

        return $blogs;
    }

    /**
     * @param Blog $blog
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(Blog $blog)
    {
        $this->em->persist($blog);

        $this->em->flush();
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function edit()
    {
        $this->em->flush();
    }

    /**
     * @param int $id
     * @return object|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function findById(int $id)
    {
        $blog = $this->em->find(Blog::class, $id);

        return $blog;
    }

    /**
     * @param Blog $blog
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Blog $blog)
    {
        $this->em->remove($blog);
        $this->em->flush();
    }
}

