<?php

use Phalcon\Forms\Form;

class ItemsForm extends Form
{
    /**
     * Initialize the Items form
     */
    private $find_options = array();

    public function initialize($entity = null, $options)
    {
        if (!is_null($entity)) {
            $data = $entity->getData();
            $selected_sub_categories = $data['categories'];
            $this->view->data = $data;
        } else {
            $selected_sub_categories = null;
        }

        $this->view->form_action = $options[0];
        $this->view->categories = $this->getParentCategories();
        $this->view->sub_categories = $this->get_sub_categories($selected_sub_categories);
        $this->find_options = array('columns'    => 'id,name',
                                    'conditions' => 'mid = ?1',
                                    'bind'       => array(1 => $selected_mid),
                                    'order'      => 'name');
        $this->view->tags = $this->get_tags();
        $this->view->pick("items/form");
    }

    public function getParentCategories()
    {
        return Categories::find(array('columns' => 'id,name', 'conditions' => 'parent_id is NULL', 'order' => 'id'));
    }

    public function get_sub_categories($selected_sub_categories)
    {
        $sub_categories = Categories::find(array('columns' => 'id,name,parent_id', 'conditions' => 'parent_id is NOT NULL', 'order' => 'id'));
        $sub_cats_array = array();
        foreach ($sub_categories as $category) {
            if (is_array($selected_sub_categories) && in_array($category->id, $selected_sub_categories)) {
                $category->selected = 1;
            }
            $sub_cats_array[] = $category;
        }
        return $sub_cats_array;
    }

    public function get_tags()
    {
        $tags = Tags::find();
        $tagslist_js = '';
        foreach ($tags as $row) {
            $tagslist_js .= '"' . $row->getTag() . '",';
        }
        return rtrim($tagslist_js, ",");
    }
}
