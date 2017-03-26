<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Message as Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Tags
 */
class Tags extends Model
{
    protected $id;
    protected $tag;

    /**
     * Tags initializer
     */
    public function initialize($id = null)
    {
        $this->hasMany('id', 'ItemsTags', 'tid', array('foreignKey' => array('action' => Relation::ACTION_RESTRICT)));
    }

    public function getData()
    {
        return array('id'  => $this->getID(),
                     'tag' => $this->getTag());
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

    public function setTag($tag)
    {
        if (empty($tag)) {
            $this->appendMessage(new Message('Tag is required.', 'tag', 'InvalidValue'));
        } else {
            $this->tag = strtolower($tag);
        }
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function isValid()
    {
        return (count($this->getMessages()) > 0 ? false : true);
    }

    public function beforeSave()
    {
        $this->validate(new Uniqueness(array(
            "field"   => array('tag'),
            "message" => "This Tag has been added before."
        )));
        return ($this->validationHasFailed() == true ? false : true);
    }
}
