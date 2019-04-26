<?php

namespace Blog\Authorisation;

use Zend\Permissions\Rbac\AssertionInterface;

class UserAssertion implements AssertionInterface
{

    private $identity;
    private $content;

    public function __construct($identity, $content)
    {
        $this->identity = $identity;
        $this->content = $content;
    }

    public function assert(\Zend\Permissions\Rbac\Rbac $rbac)
    {
        return $this->identity->getId() === $this->content->getUser()->getId();
    }
}
