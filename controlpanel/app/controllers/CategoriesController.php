<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CategoriesController extends ControllerBase
{
	private $category = null;

    public function initialize()
    {
        parent::initialize();
        $this->tag->setTitle('Manage Categories');
        $this->view->page_header = 'Manage Categories';
        $this->view->description = 'You can add, edit or delete categories';
        $this->view->categories_active = 'active';
    }

    /**
    * The start action, it shows the "search" view
    */
    public function indexAction()
    {
        $this->view->form = new CategoriesForm();
    }

	/**
    * Returning a paginator for all recoreds in this model
    */
    public function showAction()
    {
        $this->view->show_categories_active  = 'active';
        $numberPage = $this->request->getQuery("page", "int", 1);
        $categories = Categories::find();
        $paginator = new Paginator(array(
                        "data"  => $categories,
                        "limit" => 10,
                        "page"  => $numberPage)
                     );
        $this->view->page = $paginator->getPaginate();
    }

	/**
     * Shows the view to create a "new" product
     */
    public function newAction()
    {
        $this->view->new_category_active = 'active';
        $category = (!is_null($this->category) ? $this->category : null);
        $this->view->form = new CategoriesForm($category, 'create');
    }

	/**
     * Shows the view to "edit" an existing product
     */
    public function editAction($id)
    {
        if(!$this->request->isPost()) {
            $category = Categories::findFirstById($id);
            if (!$category) {
                $this->flash->error("Category was not found");
                return $this->forward("categories/index");
            }

            $this->view->form = new CategoriesForm($category, 'save');
            $this->logger->log('cp', "edit category (cid = $id)");
        }
    }

	/**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("categories/index");
        }
        $category = new Categories();
        $category->setID(2);
        $category->setParentID($this->request->getPost('parent_id', 'int'));
        $category->setName($this->request->getPost('name', 'string'));
        $category->setDescription($this->request->getPost('description', 'string'));
        $this->category = $category;

        if (!$category->isValid()) {
            $this->flash->error($category->getMessages());
            return $this->forward('categories/new');
        }

        if ($category->save() == false) {
            $this->flash->error($category->getMessages());
            return $this->forward('categories/new');
        }

        $this->flash->success("Category was created successfully");
        $this->logger->log('cp', 'added category (cid = ' . $category->getID() . ')');
        return $this->forward("categories/show");
    }

    /**
    * Updates a product based on the data entered in the "edit" action
    */
	public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("categories/index");
        }
        $id = $this->request->getPost("id", "int");
        $category = Categories::findFirstById($id);
        if (!$category) {
            $this->flash->error("Category does not exist");
            return $this->forward("categories/index");
        }

        $category->setParentID($this->request->getPost('parent_id', 'int'));
        $category->setName($this->request->getPost('name', 'string'));
        $category->setDescription($this->request->getPost('description', 'string'));

        if (!$category->isValid()) {
            $this->flash->error($category->getMessages());
            return $this->forward('categories/edit/' . $id);
        }

        if ($category->save() == false) {
            $this->flash->error($category->getMessages());
            return $this->forward('categories/edit/' . $id);
        }

        $this->flash->success("Category was updated successfully");
        $this->logger->log('cp', 'edited category (cid = ' . $category->getID() . ')');
        return $this->forward("categories/show");
    }

	/**
     * Deletes an existing product
     */
    public function deleteAction($id)
    {
        $category = Categories::findFirstById($id);
        if (!$category) {
            $this->flash->error("Category was not found");
            return $this->forward("categories/index");
        }
        if (!$category->delete()) {
            foreach ($category->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward("categories/show");
        }
        $this->logger->log('cp', "deleted category (cid = $id)");
        $this->flash->success("Category was deleted");
        return $this->forward("categories/show");
    }
}
