<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use User\Form\LoginForm;
use User\Form\RegisterForm;
use User\Entity\User;
use Doctrine\ORM\EntityManager;
use User\Services\MailService;
use Zend\Log\LoggerServiceFactory;

class UserController extends AbstractActionController
{

    protected $authService;
    protected $em;
    protected $mailService;

    public function __construct(AuthenticationService $authService, EntityManager $em, MailService $mailService)
    {
        $this->authService = $authService;
        $this->em = $em;
        $this->mailService = $mailService;
    }

    public function loginAction()
    {
        $form = new LoginForm();

        $form->get('submit')->setValue('Login');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();
            $adapter = $this->authService->getAdapter();
            $adapter->setIdentity($data['email']);
            $adapter->setCredential($data['password']);
            $authResult = $this->authService->authenticate();
            if ($authResult->isValid()) {
                $this->log()->info("User ".$data['email']." Logged in at ".date("Y-m-d H:i:s")); 
                return $this->redirect()->toRoute('blog');
            } else {
                
                $this->flashMessenger()->addMessage('Incorrect Credentials!!!!!');
                return $this->redirect()->toRoute('user');
            }
        }

        return [
            'form' => $form
        ];
    }

    public function logoutAction()
    {
        if ($this->identity()) {
            $this->authService->clearIdentity();

            return $this->redirect()->toRoute('user');
        }
    }

    public function registerAction()
    {
        $form = new RegisterForm();

        $form->get('submit')->setValue('Register');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();
            $user = new User();
            $form->setInputFilter($user->getInputFilter());
            $form->setData($data);
            if ($form->isValid()) {
                $email = $this->em->getRepository(User::class)->findOneByemail($data['email']);
                if (!$email) {
                    $user->exchangeArray($form->getData());
                    $password = $data['password'];
                    $hash = password_hash($password, PASSWORD_BCRYPT);
                    $user->setPassword($hash);
                    $user->setRole(1);
                    $this->em->persist($user);
                    $this->em->flush();
                    $this->mailService->sendMail($user);

                    return $this->redirect()->toRoute('user');
                }
                $this->flashMessenger()->addMessage('Account already Exists with this email id');
                return [
                    'form' => $form
                ];
            }
        }

        return [
            'form' => $form
        ];
    }

    public function log()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('Log');
    }

}
