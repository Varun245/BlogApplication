<?php
declare (strict_types=1);

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Blog\Form\BlogForm;
use Blog\Entity\Blog;
use Blog\Contracts\BlogServiceInterface;

/**
 * Class BlogController
 * @package Blog\Controller
 */
class BlogController extends AbstractActionController
{
    protected $blogService;

    protected $authenticationService;

    /**
     * BlogController constructor.
     * @param BlogServiceInterface $blogService
     */
    public function __construct(BlogServiceInterface $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $blogs = $this->blogService->findAllBlogs();

        return new ViewModel([
            'blogs' => $blogs
        ]);
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function  addAction()
    {
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
                $this->blogService->add($blog);

                return $this->redirect()->toRoute('blog');
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

        $blog = $this->blogService->findById($id);

        $form = new BlogForm();
        $form->bind($blog);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($blog->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->blogService->edit();

                return $this->redirect()->toRoute('blog');
            }
        }

        return [
            'id' => $id,
            'form' => $form,
        ];
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        if (!$id) {

            return $this->redirect()->toRoute('blog');
        }

        $blog = $this->blogService->findById($id);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('del');
            if ($del == 'Yes') {
                $this->blogService->delete($blog);
            }

            return $this->redirect()->toRoute('blog');
        }

        return array(
            'id'    => $id,
            'blog' => $blog
        );
    }
}

