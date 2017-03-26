<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Message as Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;
/**
 * Items
 */
class Items extends Model
{
	protected $id;
	protected $name;
    protected $description;
	protected $last_update;

	/**
    * Items initializer
    */
    public function initialize($id = null)
    {
        $this->hasMany('id', 'ItemsCategories', 'sid', array('foreignKey' => array('action' => Relation::ACTION_CASCADE)));
        $this->hasMany('id', 'ItemsTags', 'sid', array('foreignKey' => array('action' => Relation::ACTION_CASCADE)));
        $this->hasMany('id', 'ItemsMedia', 'sid', array('foreignKey' => array('action' => Relation::ACTION_CASCADE)));
    }

	public function getData()
    {
        return array('id' => $this->getID(),
                     'name' => $this->getName(),
                     'description' => $this->getDescription(),
                     'categories' => $this->getItemCategoriesIDs(),
			         'tagslist' => $this->getItemTagsList(),
			         'media' => $this->getItemImages());
        }

	public function setID($id)
    {
        if(!is_numeric($id)) {
            $this->appendMessage(new Message('ID is invalid.', 'id', 'InvalidValue'));
        }
        else {
            $this->id = $id;
        }
    }

    public function getID()
    {
        return $this->id;
    }

	public function setName($name)
    {
        if(empty($name))
            $this->appendMessage(new Message('Name is required.', 'name', 'InvalidValue'));
        else
            $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

	public function isValid()
    {
        return (count($this->getMessages()) > 0 ? false : true);
    }

	public function setDescription($description)
    {
        if(empty($description)) {
            $this->appendMessage(new Message('Description is required.', 'description', 'InvalidValue'));
        }
        else {
            $this->description = $description;
        }
    }

    public function getDescription()
    {
        return $this->description;
    }

	public function setLastUpdate()
    {
		$this->last_update = date("Y-m-d H:i:s");;
	}

	public function getLastUpdate()
    {
		return $this->last_update;
	}

	public function getItemCategoriesIDs()
    {
		$categories_array = array();
		if($this->getID() > 0){
			$categories 	  = $this->getItemsCategories();
			foreach($categories as $category){
				$categories_array[] = $category->getCategoryID();
			}
		}
		return $categories_array;
	}
	
	public function getItemTagsList()
    {
		$tagslist = '';
        $tagslist_js = '';
		if($this->getID() > 0) {
			$tags = $this->getItemsTags();
			foreach($tags as $row){
				$tagslist .= $row->getTags()->getTag() . ',';
				$tagslist_js .= '"' . $row->getTags()->getTag() . '",';
			}
		}
		return array(rtrim($tagslist, ","), rtrim($tagslist_js, ","));
	}

	public function getItemTagsListIDs()
    {
		$tagslist       = array();
		if($this->getID() > 0) {
			$tags           = $this->getItemsTags();
			foreach($tags as $row){
				$tagslist[] = $row->getTID();
			}
		}
		return $tagslist;
	}

	public function getItemImages()
    {
		$images = array();
		if($this->getID() > 0) {
			$media = $this->getItemsMedia();
			$images = array();
			$path	= $this->di->get('config')->application['filesBaseUri'] . $this->di->get('config')->Items['images']['imagedir'] . sprintf('%03d', $this->getMallID()) . '/ld/';
			$images['path'] = $path;
			foreach($media as $image) {
				$images['images'][] = $image->getFilename();;
			}
		}
		return $images;
	}

	public function beforeDelete()
    {
		// Delete all Items tags directly from DB
		$this->getDi()->getShared('db')->delete("Items_tags", "sid = ?", array($this->id));
		$this->getDi()->getShared('db')->delete("Items_categories", "sid = ?", array($this->id));
		$media = $this->getItemsMedia();
		foreach($media as $image) {
			$image->delete();
        }
	}

    public function beforeSave()
    {
        $this->setLastUpdate();
        $this->validate(new Uniqueness(array("field"   => array('mid', 'code'), "message" => "This Item has been added before.")));
        return ($this->validationHasFailed() == true ? false : true);
    }
}
