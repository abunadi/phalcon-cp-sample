<?php
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Message as Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Items Categories
 */
class ItemsCategories extends Model
{
    protected $id;
    protected $sid;
    protected $cid;

    public function getSource()
    {
        return "items_categories";
    }

    /**
     * Items Categories initializer
     */
    public function initialize($id = null)
    {
        $this->belongsTo('sid', 'Items', 'id');
        $this->belongsTo('cid', 'Categories', 'id');
    }

    public function setID($id)
    {
        if (!is_numeric($id))
            $this->appendMessage(new Message('ID is invalid.', 'id', 'InvalidValue'));
        else
            $this->id = $id;
    }

    public function getID()
    {
        return $this->id;
    }

    public function setitemID($sid)
    {
        if (!is_numeric($sid))
            $this->appendMessage(new Message('SID is invalid.', 'sid', 'InvalidValue'));
        else
            $this->sid = $sid;
    }

    public function getitemID()
    {
        return $this->sid;
    }

    public function setCategoryID($cid)
    {
        if (!is_numeric($cid))
            $this->appendMessage(new Message('CID is invalid.', 'cid', 'InvalidValue'));
        else
            $this->cid = $cid;
    }

    public function getCategoryID()
    {
        return $this->cid;
    }

    public function isValid()
    {
        return (count($this->getMessages()) > 0 ? false : true);
    }

    public function beforeSave()
    {
        $this->validate(new Uniqueness(array(
            "field"   => array('sid', 'cid'),
            "message" => "This Tag has been added before to this item."
        )));
        return ($this->validationHasFailed() == true ? false : true);
    }
}
