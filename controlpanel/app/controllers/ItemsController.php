<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ItemsController extends ControllerBase
{
	private $item = null;

    public function initialize()
    {
        parent::initialize();
        $this->tag->setTitle('Manage Items');
        $this->view->page_header = 'Manage Items';
        $this->view->description = 'You can add, edit, delete or search for Items';
        $this->view->items_active = 'active';
    }

    /**
    * The start action, it shows the "search" view
    */
    public function indexAction()
    {
        $this->view->form = new ItemsForm();
    }

	/**
    * Returning a paginator for all recoreds in this model
    */
    public function showAction()
    {
        $this->view->show_itemss_active  = 'active';
        $numberPage = $this->request->getQuery("page", "int", 1);
        $items = Items::find();
        $paginator = new Paginator(array(
                         "data"  => $items,
                         "limit" => 10,
                         "page"  => $numberPage));
        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Shows the view to create a "new" product
     */
    public function newAction()
    {
        $this->view->new_item_active    = 'active';
        $item = (!is_null($this->item) ? $this->item : null);
        $this->view->form = new ItemsForm($item, array('create'));
    }

	/**
     * Shows the view to "edit" an existing product
     */
    public function editAction($id)
    {
        if(!$this->request->isPost()){
            $item = Items::findFirstById($id);
            if (!$item) {
                $this->flash->error("Item was not found");
                return $this->forward("items/index");
            }

            $this->view->form = new ItemsForm($item, array('save'));
            $this->logger->log('cp', "edit item (sid = $id)");
        }
    }

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("items/new");
        }
        $item = new Items();

        $item->setName($this->request->getPost('name', 'string'));
        $item->setDescription($this->request->getPost('description', 'string'));
		$this->item = $item;
		if(!$item->isValid()) {
            $this->flash->error($item->getMessages());
            return $this->forward('items/new/');
        }
		$item_categories = $this->__processCategories($this->request->getPost('categories', 'string'));
		if (!$item_categories) {
			$this->flash->error("Category is required.");
            return $this->forward('items/new/');
		}
		$item_image = null;
		//Check if the user has uploaded files
		if ($this->request->hasFiles() == true) {
			//Print the real file names and their sizes
			$image = new ImagesUploader($this->config->items['images'], $this->config->application['filesPath'], $item->getMallID());
		
			foreach ($this->request->getUploadedFiles() as $file){
				if($file->isUploadedFile()){
					$image->loadImage($file);
					$filename = $image->resize_and_save();
					if(!$filename){
						$this->flash->error("Image could not be saved.");
                        			return $this->forward('items/new/');
					}
					$item_image = new ItemsMedia();
					$item_image->setFilename($filename);
					if (!$item_image->isValid()) {
						$this->flash->error($item_image->getMessages());
						return $this->forward('items/new/');
					}
					if ($item_image->save() == false) {
						$this->flash->error($item_image->getMessages());
						return $this->forward('items/new');
					}
				}
			}
		}

		$tagslist = $this->request->getPost('tagslist', 'string');
		if(!empty($tagslist)){
			$item_tags 	= $this->__processTags($tagslist);
		}
                if($item->save() == false) {
                        $this->flash->error($item->getMessages());
                        return $this->forward('items/new');
                }

		$this->__saveitemCategories($item_categories, $item->getID());
		$this->__saveTags($item_tags, $item->getID());
		
		if(!is_null($item_image)){
			$item_image->setitemID($item->getID());
			$item_image->save();
		}
                $this->flash->success("item was created successfully");
		$this->logger->log('cp', 'added item (sid = ' . $item->getID() . ')');
                return $this->forward("items/show");
        }

        /**
        * Updates a product based on the data entered in the "edit" action
        */
	public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("items/index");
        }
        $id = $this->request->getPost("id", "int");
        $item = Items::findFirstById($id);
        if (!$item) {
            $this->flash->error("item does not exist");
            return $this->forward("items/index");
        }
        $item->setName($this->request->getPost('name', 'string'));
        $item->setDescription($this->request->getPost('description', 'string'));
		if (!$item->isValid()) {
            $this->flash->error($item->getMessages());
            return $this->forward('items/edit/' . $id);
        }
		$item_categories = $this->__processCategories(array('1,1'));
        if (!$item_categories){
            $this->flash->error("Category is required.");
            return $this->forward('items/new/');
        }
		$item_image 	 = null;
		$item_image_del = $this->request->getPost('item_image_del', 'string');
        //Check if the user has uploaded files
        if ($this->request->hasFiles() == true) {
            //Print the real file names and their sizes
            $image = new ImagesUploader($this->config->items['images'], $this->config->application['filesPath'], $item->getMallID());

            foreach ($this->request->getUploadedFiles() as $file){
                if($file->isUploadedFile()){
                    $image->loadImage($file);
                    $filename = $image->resize_and_save();
                    if(!$filename){
                            $this->flash->error("Image could not be saved.");
                            return $this->forward('items/new/');
                    }
                    $item_image = new ItemsMedia();
                    $item_image->setFilename($filename);
                    $item_image->setitemID($item->getID());
                    if (!$item_image->isValid()) {
                        $this->flash->error($item_image->getMessages());
                        return $this->forward('items/new/');
                    }
                    if ($item_image->save() == false) {
                        $this->flash->error($item_image->getMessages());
                        return $this->forward('items/new');
                    }
                }
            }
        }

		$tagslist = $this->request->getPost('tagslist', 'string');
        if (!empty($tagslist)) {
            $item_tags     = $this->__processTags($tagslist);
        }

        if ($item->save() == false) {
            $this->flash->error($item->getMessages());
            return $this->forward('items/edit/' . $id);
        }

		$old_categories = $item->getitemCategoriesIDs();
		$this->__saveitemCategories($item_categories, $item->getID(), $old_categories);	
		$old_tags = $item->getitemTagsListIDs();
		$this->__saveTags($item_tags, $item->getID(), $old_tags);
		if(!empty($item_image_del)){
			$img_del = ItemsMedia::findFirst(array('conditions' => 'sid = ?0 and filename = ?1',
                                                   'bind'       => array($item->getID(), $item_image_del)));
            $img_del->delete();
        }
		$this->__deleteTags($item_tags ,$old_tags, $item->getID());
		$this->__deleteCategories($item_categories, $old_categories, $item->getID());
                $this->flash->success("item was updated successfully");
		$this->logger->log('cp', 'edited item (sid = ' . $item->getID() . ')');
                return $this->forward("items/show");
    }

    /**
     * Deletes an existing product
     */
	public function deleteAction($id)
    {
        $item = Items::findFirstById($id);
        if (!$item) {
            $this->flash->error("item was not found");
            return $this->forward("items/index");
        }

        if (!$item->delete()) {
            foreach ($item->getMessages() as $message) {
                    $this->flash->error($message);
            }
            return $this->forward("items/show");
        }
        $this->logger->log('cp', "deleted item (sid = $id)");
        $this->flash->success("item was deleted");
        return $this->forward("items/show");
    }

	/**
	 * Process Tags from form
	*/
	public function __processTags($tagslist){
		$item_tags = array();
		$tagslist = explode(',', $tagslist);
		for($i=0; $i < count($tagslist); $i++){
			if(!empty($tagslist[$i])){
				$tag = Tags::findFirst(array(
					"tag = :tag:",
					'bind' => array('tag' => strtolower($tagslist[$i]))
					));
				if($tag == false){ // tag is not exist
					$save_tag = new Tags();
					$save_tag->setTag($tagslist[$i]);
					if (!$save_tag->isValid()) {
						$this->flash->error($save_tag->getMessages());
						return $this->forward('items/new/');
					}
					if($save_tag->save() == false) {
						$this->flash->error($save_tag->getMessages());
						return $this->forward('items/new');
					}
					$item_tags[] = $save_tag->getID();
				}
				else{
					$item_tags[] = $tag->getID();
				}
			}
		}
		return $item_tags;
	}

	/**
    * Save item Categories
    */
    public function __saveitemCategories($categories, $sid, $current_categories = array()){
        if(is_array($categories)){
            for($i=0; $i < count($categories); $i++){
                if($categories[$i] > 0 && !in_array($categories[$i], $current_categories)){
                    $item_category = new ItemsCategories();
                    $item_category->setCategoryID($categories[$i]);
                    $item_category->setitemID($sid);
                    if (!$item_category->isValid()) {
                        $this->flash->error($item_category->getMessages());
                        return $this->forward('items/new/');
                    }
                    if($item_category->save() == false) {
                        $this->flash->error($item_category->getMessages());
                        return $this->forward('items/new');
                    }
                }
            }
        }
    }

	/**
	 * Save tags
	*/
	public function __saveTags($item_tags, $sid, $current_tags = array())
    {
		if(is_array($item_tags)){
            for($i=0; $i < count($item_tags); $i++){
                if($item_tags[$i] > 0 && !in_array($item_tags[$i], $current_tags)){
                    $save_item_tags = new ItemsTags();
                    $save_item_tags->setSID($sid);
                    $save_item_tags->setTID($item_tags[$i]);
                    if (!$save_item_tags->isValid()) {
                            $this->flash->error($save_item_tags->getMessages());
                            return $this->forward('items/new/');
                    }
                    if($save_item_tags->save() == false) {
                            $this->flash->error($save_item_tags->getMessages());
                            return $this->forward('items/new');
                    }
                }
            }
        }
	}

	/**
     * Delete categories
    */
    public function __deleteCategories($new_categories, $old_categories, $sid){
        if(is_array($new_categories) && is_array($old_categories)){
            $del_categories = array_values(array_diff($old_categories, $new_categories));
            for($i=0; $i < count($del_categories); $i++){
                    $this->getDi()->getShared('db')->delete("items_categories", "sid = ? and cid = ?", array($sid, $del_categories[$i]));
            }
        }
    }
	
	/**
  	 * Delete tags
	*/
	public function __deleteTags($new_tags, $old_tags, $sid){
		if(is_array($new_tags) && is_array($old_tags)){
			$del_tags = array_values(array_diff($old_tags, $new_tags));	
			for($i=0; $i < count($del_tags); $i++){
				$this->getDi()->getShared('db')->delete("items_tags", "sid = ? and tid = ?", array($sid, $del_tags[$i]));
			}
		}
	}

	/**
	* Process Categories from the form and split them into main and sub categories
	*/
	public function __processCategories($categories)
    {
		if(is_array($categories)) {
			$item_categories = array();
			for($i=0; $i < count($categories); $i++) {
				$cat = explode(',', $categories[$i]);
				if(!in_array($cat[0], $item_categories)) {
                    $item_categories[] = $cat[0];
                }

				if(!in_array($cat[1], $item_categories)) {
                    $item_categories[] = $cat[1];
                }
			}
			return $item_categories;
		}
		else {
            return false;
        }
	}
}
