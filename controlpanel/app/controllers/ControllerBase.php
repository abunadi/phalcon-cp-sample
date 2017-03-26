<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->setTitle('Control Panel');
        $this->tag->setTitleSeparator(" - ");
        $this->view->auth = ($this->session->has('auth') ? 1 : 0);
        if ($this->view->auth) {
            $this->view->page_header = '';
            $this->view->description = '';
        }
    }

    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);
        $params = array_slice($uriParts, 2);
        return $this->dispatcher->forward(
            array(
                'controller' => (isset($uriParts[0]) ? $uriParts[0] : null),
                'action'     => (isset($uriParts[1]) ? $uriParts[1] : null),
                'params'     => $params
            )
        );
    }
}
