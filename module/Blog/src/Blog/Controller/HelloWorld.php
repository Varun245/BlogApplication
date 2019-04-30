<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class HelloWorld extends AbstractPlugin{

    public function __invoke()
    {
        return $this->hello();
    }

    public function hello()
    {
        echo "Hello World !!!";
    }

}

