<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Message as Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Categories
 */
class Categories extends Model
{
    protected $id;
    protected $parent_id;
    protected $name;
    protected $description;

    /**
     * Parents initializer
     */
    public function initialize()
    {
        $this->belongsTo('parent_id', 'Categories', 'id');
        $this->hasMany('id', 'ItemsCategories', 'cid',
            array('foreignKey' => array('action' => Relation::ACTION_RESTRICT))
        );
    }

    public function getData()
    {
        return array('id'          => $this->getID(),
                     'parent_id'   => $this->getParentID(),
                     'name'        => $this->getName(),
                     'description' => $this->getDescription());
    }

    public function setID($id)
    {
        if (!is_numeric($id)) {
            $this->appendMessage(new Message('ID is invalid.', 'id', 'InvalidValue'));
        } else {
            $this->id = $id;
        }
    }

    public function getID()
    {
        return $this->id;
    }

    public function setParentID($id)
    {
        if (!empty($id) && is_numeric($id)) {
            $this->parent_id = $id;
        }
    }

    public function getParentID()
    {
        return $this->parent_id;
    }

    public function setName($name)
    {
        if (empty($name)) {
            $this->appendMessage(new Message('Name is required.', 'name', 'InvalidValue'));
        } else {
            $this->name = $name;
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        if (empty($description)) {
            $this->appendMessage(new Message('Description is required.', 'description', 'InvalidValue'));
        } else {
            $this->description = $description;
        }
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function isValid()
    {
        return (count($this->getMessages()) > 0 ? false : true);
    }


    public function beforeSave()
    {
        /*  $this->validate(
              new Uniqueness(
                  array("field"   => array('parent_id', 'name'),
                        "message" => "This Category has been added before."
                  )
              )
          );
          return ($this->validationHasFailed() == true ? false : true);*/
    }
}
