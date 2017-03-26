<?php

class IndexController extends ControllerBase
{
    protected function initialize()
    {
        parent::initialize();
        if ($this->view->auth) {
            $this->tag->prependTitle('Dashboard');
            $this->view->page_header = 'Dashboard';
            $this->view->description = 'Control panel';
            $this->view->dashboard_active = 'active';
        }
    }

    public function indexAction()
    {
        if ($this->view->auth) {
            //$categories 	    = Malls::find();
            //$items 			= Items::find();
            $this->view->malls_count = 10;
            $this->view->stores_count = 20;
        }
    }
}
