<?php

use Phalcon\Forms\Form;

class CategoriesForm extends Form
{
    /**
     * Initialize the categories form
     */
    public function initialize($entity = null, $send_to)
    {
        if (!is_null($entity)) {
            $this->view->data = $entity->getData();
        }
        $this->view->form_action = $send_to;
        $this->view->parent_categories = $this->getParentCategories();
        $this->view->pick("categories/form");
    }

    public function getParentCategories()
    {
        return Categories::find(array('columns' => 'id,name', 'conditions' => 'parent_id is NULL', 'order' => 'name'));
    }
}
