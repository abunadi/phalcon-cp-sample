<?php
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Message as Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * ItemsTags
 */
class ItemsTags extends Model
{
    protected $id;
    protected $sid;
    protected $tid;

    public function getSource()
    {
        return "items_tags";
    }

    /**
     * Items Tags initializer
     */
    public function initialize($id = null)
    {
        $this->belongsTo('sid', 'Items', 'id');
        $this->belongsTo('tid', 'Tags', 'id');
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

    public function setSID($sid)
    {
        if (!is_numeric($sid)) {
            $this->appendMessage(new Message('SID is invalid.', 'sid', 'InvalidValue'));
        } else {
            $this->sid = $sid;
        }
    }

    public function getSID()
    {
        return $this->sid;
    }

    public function setTID($tid)
    {
        if (!is_numeric($tid)) {
            $this->appendMessage(new Message('TID is invalid.', 'tid', 'InvalidValue'));
        } else {
            $this->tid = $tid;
        }
    }

    public function getTID()
    {
        return $this->tid;
    }

    public function isValid()
    {
        return (count($this->getMessages()) > 0 ? false : true);
    }

    public function beforeSave()
    {
        $this->validate(new Uniqueness(array(
            "field"   => array('sid', 'tid'),
            "message" => "This Tag has been added before to this item."
        )));
        return ($this->validationHasFailed() == true ? false : true);
    }
}
