<?php

namespace User\Form;

class LoginForm extends form{

    public function __construct($name=null)
    {
        parent::__construct('login');


        $this->add([
            'name'=>'email',
            'type'=>'Hidden',
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