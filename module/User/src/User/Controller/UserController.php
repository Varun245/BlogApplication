<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use User\Form\LoginForm;

class UserController extends AbstractActionController{

    protected $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService=$authService;
    }

    public function loginAction()
    {
        $form = new LoginForm();

        $form->get('submit')->setValue('Create');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data=$request->getPost();

     
        $data=[
            'email'=>'varun@gmail.com',
            'password'=>'$2y$12$22mlJGv2l248Iiz6P82YY.Ej4Z8iu/8ytxjoRxOl4/WmXeXa7QvYS'
        ];

       $adapter=$this->authService->getAdapter();
       $adapter->setIdentity($data['email']);     
       $adapter->setCredential($data['password']);
       $authResult = $this->authService->authenticate();
       
       return $this->redirect()->toRoute('blog');
           
    }



}