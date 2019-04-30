<?php
declare (strict_types = 1);

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Blog\Form\BlogForm;
use Blog\Entity\Blog;
use Blog\Interfaces\BlogServiceInterface;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;
use Blog\Authorisation\UserAssertion;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter;
use Zend\Paginator\Paginator;
use DOMPDFModule\View\Model\PdfModel;

/**
 * Class BlogController
 * @package Blog\Controller
 */
class BlogController extends AbstractActionController
{
    /**
     * @var BlogServiceInterface
     */
    protected $blogService;
    protected $em;

    protected $authenticationService;

    /**
     * BlogController constructor.
     * @param BlogServiceInterface $blogService
     * @param EntityManager $em
     */
    public function __construct(BlogServiceInterface $blogService,EntityManager $em)
    {
        $this->blogService = $blogService;
        $this->em = $em;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $blogs = $this->blogService->findAllBlogs();

        $adapter = new SelectableAdapter($this->em->getRepository(Blog::class));
        $itemsPerPage = 5;
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber(1)
                ->setItemCountPerPage($itemsPerPage);
            
      
        return new ViewModel([
            'blogs' => $blogs,
            'paginator' => $paginator,
           
        ]);

     
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function  addAction()
    {

        $userId = $this->identity()->getId();

        $form = new BlogForm();

        $form->get('submit')->setValue('Create');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $request->getPost();
            $blog = new Blog();
            $form->setInputFilter($blog->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $blog->exchangeArray($form->getData());
                $this->blogService->add($blog, $userId);

                return $this->redirect()->toRoute('blog/default', array('action' => 'userBlogs'));
            }
        }

        return [
            'form' => $form
        ];
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function editAction()
    {
       
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('blog', array(
                'action' => 'add'
            ));
        }

        $identity = $this->identity();
        $blog = $this->blogService->findById($id);
        $userAssertion = new UserAssertion($identity, $blog);

        $user = new Role('user');
        $user->addPermission('edit');
        $rbac = new Rbac();
        $rbac->addRole($user);

        if ($rbac->isGranted($user, 'edit', $userAssertion)) { } else {
            throw new UnauthorizedException('Not ALlowed');
        }

        $form = new BlogForm();
        $form->bind($blog);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($blog->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->blogService->edit();

                return $this->redirect()->toRoute('blog/default', array('action' => 'userBlogs'));
            }
        }

        return [
            'id' => $id,
            'form' => $form,
        ];
    }


    /**
     * @return array|\Zend\Http\Response
     * @throws \Exception
     */
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        if (!$id) {

            return $this->redirect()->toRoute('blog');
        }
        else{

            throw new \Exception('Id Not found');
        }

        $blog = $this->blogService->findById($id);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('del');
            if ($del === 'Yes') {
                $this->blogService->delete($blog);
            }

            return $this->redirect()->toRoute('blog/default', array('action' => 'userBlogs'));
        }

        return array(
            'id'    => $id,
            'blog' => $blog
        );
    }

    public function userBlogsAction()
    {
        $userId = (int)$this->identity()->getId();
        $blogs = $this->blogService->userBlogs($userId);

        return new ViewModel([
            'blogs' => $blogs,
        ]);
    }
}


