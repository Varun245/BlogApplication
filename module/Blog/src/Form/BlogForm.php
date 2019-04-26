<?php
declare (Strict_types = 1);

namespace Blog\Form;

use Zend\Form\Form;

/**
 * Class BlogForm
 * @package Blog\Form
 */
class BlogForm extends Form
{
    /**
     * BlogForm constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('blog');

        $this->add([
            'name' => 'id',
            'type' => 'Hidden',
        ]);

        $this->add([
            'name' => 'title',
            'type' => 'Text',
        ]);

        $this->add([
            'name' => 'description',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => [
                'rows' => 10,
                'cols' => 100
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Create',
                'id' => 'submitbutton',
            ]
        ]);
    }
}
