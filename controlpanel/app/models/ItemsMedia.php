<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message as Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Media
 */
class ItemsMedia extends Model
{
    protected $id;
    protected $sid;
    protected $filename;
    protected $uploaded_at;

    /**
     * Media initializer
     */
    public function initialize($id = null)
    {
        $this->belongsTo('sid', 'Items', 'id');
    }

    public function getSource()
    {
        return "items_media";
    }

    public function getData()
    {
        return array('id'          => $this->getID(),
                     'sid'         => $this->getitemID(),
                     'filename'    => $this->getFilename(),
                     'uploaded_at' => $this->getUploadedTime());
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

    public function setitemID($id)
    {
        if (!is_numeric($id))
            $this->appendMessage(new Message('item ID is invalid.', 'sid', 'InvalidValue'));
        else
            $this->sid = $id;
    }

    public function getitemID()
    {
        return $this->sid;
    }

    public function setFilename($filename)
    {
        if (empty($filename))
            $this->appendMessage(new Message('Filename is required.', 'name', 'InvalidValue'));
        else
            $this->filename = $filename;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setUploadedTime()
    {
        $this->uploaded_at = date("Y-m-d H:i:s");
    }

    public function getUploadedTime()
    {
        return $this->uploaded_at;
    }

    public function isValid()
    {
        return (count($this->getMessages()) > 0 ? false : true);
    }

    public function beforeDelete()
    {
        $path = $this->di->get('config')->application['filesPath'] . $this->di->get('config')->items['images']['imagedir'] . substr($this->getFilename(), 0, 3) . '/';
        $folders = $this->di->get('config')->items['images']['resize'];
        foreach ($folders as $folder => $res) {
            @unlink($path . $folder . '/' . $this->getFilename());
        }
        return true;
    }

    public function beforeSave()
    {
        $this->setUploadedTime();
        $this->validate(new Uniqueness(array(
            "field"   => array('filename'),
            "message" => "This Image has been added before."
        )));
        return ($this->validationHasFailed() == true ? false : true);
    }
}
