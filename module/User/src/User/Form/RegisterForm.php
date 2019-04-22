<?php

namespace User\Form;

use Zend\Form\Form;

class RegisterForm extends Form{

    public function __construct($name=null)
    {
        parent::__construct('register');
        
        $this->add([
            'name'=>'id',
            'type'=>'Hidden',
        ]);

        $this->add([
            'name'=>'firstName',
            'type'=>'text',
        ]);

        $this->add([
            'name'=>'lastName',
            'type'=>'text',
        ]);

        $this->add([
            'name'=>'email',
            'type'=>'text',
        ]);

        $this->add([
            'name'=>'password',
            'type'=>'password',
        ]);

        $this->add([
            'name'=>'confirmPassword',
            'type'=>'password',
        ]);


        $this->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Register',
                'id' => 'submitbutton',
            ]
        ]);
    }
}
