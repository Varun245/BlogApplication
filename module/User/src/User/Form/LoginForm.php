<?php

namespace User\Form;

use Zend\Form\Form;

class LoginForm extends Form{

    public function __construct($name=null)
    {
        parent::__construct('login');

        $this->add([
            'name'=>'email',
            'type'=>'Text',
        ]);

        $this->add([
            'name'=>'password',
            'type'=>'password',
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Submit',
                'id' => 'submitbutton',
            ]
        ]);
    }
}
