<?php

namespace User\Acl;

use Zend\Permissions\Acl\Acl as BaseAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class AclModel extends BaseAcl{

    public function __construct()
    {
        $this->addRole(new Role('User')); 
        $this->addResource(new Resource('BlogController'));
        $this->allow('User', 'BlogController', 'edit');
    }

}