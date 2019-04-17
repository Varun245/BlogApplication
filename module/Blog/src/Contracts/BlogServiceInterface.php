<?php
declare(strict_types=1);

namespace Blog\Contracts;

use Blog\Entity\Blog;

/**
 * Interface BlogServiceInterface
 * @package Blog\Contracts
 */
interface BlogServiceInterface
{
    /**
     * Show all blogs 
     * 
     * @return array
     */
    public function findAllBlogs(): array;

    /**
     * Adding a new Blog
     * 
     * @param Blog $blog
     * @return mixed
     */
    public function add(Blog $blog);

    /**
     * Edit the Blog 
     * 
     * @return mixed
     */
    public function edit();

    /**
     * For Deleting a blog
     * 
     * @param Blog $blog
     * @return mixed
     */
    public function delete(Blog $blog);

    /**
     * Finding the blog by id
     * 
     * @param $id
     * @return Blog
     */
    public function findById(int $id): Blog;
}

