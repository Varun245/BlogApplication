<?php
declare (strict_types = 1);

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;  

/** @ORM\Entity */
class User implements InputFilterAwareInterface {

     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /** @ORM\Column(type="string") */
    private $firstName;

    /** @ORM\Column(type="string") */
    private $lastName;

    /** @ORM\Column(type="string") */
    private $email;

     /** @ORM\Column(type="string") */
    private $password;

    protected $inputFilter;

    /**
     * @oneToMany(targetEntity="Blog\Entity\Blog",mappedBy="user")
     */
    private $blogs;

    public function __construct()
    {
        $this->blogs=new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
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
    public function getPassword()
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

    public function getBlogs(): ArrayCollection
    {
        return $this->blogs;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName=$firstName;
    }

    public function getLastName()
    {
        return $this->firstName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName=$lastName;
    }

    /**
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this);
    }

    public function exchangeArray($data)
    {
        $this->id=$data['id'];
        $this->firstName=$data['firstName'];
        $this->lastName=$data['lastName'];
        $this->email=$data['email'];
        $this->password=$data['password'];
    }

      /**
     * @param InputFilterInterface $inputFilter
     * @return void|InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new Exception('Not Used');
    }


    public function getInputFilter()
    {
        $inputFilter = new InputFilter();

        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'firstName',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1 ,
                            'max' => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'lastName',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            ));


            $inputFilter->add(array(
                'name' => 'email',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                    array(
                        'name'=>'EmailAddress',
                        'options'=>array(
                            'message'=>'Not a Valid Email Address'
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'password',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 8,
                            'max' => 20,
                            'message'=>'Password should be of 8 characters'
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'confirmPassword',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'=>'Identical',
                        'options' => array(
                            'token' => 'password', 
                            'message'=>'Password are not Matching'
                        ),
                    ),
                ),
            ));

            

            

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}