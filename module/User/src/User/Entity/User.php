<?php
declare (strict_types = 1);

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;

/** @ORM\Entity */
class User {

     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /** @ORM\Column(type="string") */
    private $email;

     /** @ORM\Column(type="string") */
    private $password;

    /**
     * @oneToMany(targetEntity="Blog\Entity\Blog",mappedBy="user")
     */
    private $blogs;

    public function __construct()
    {
       // $this->blogs=new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail():string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword():string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getBlogs()
    {
        return $this->blogs;
    }
}
