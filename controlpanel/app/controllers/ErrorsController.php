<?php

class ErrorsController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Oops!');
        parent::initialize();
    }

    public function show404Action()
    {
        $this->flash->error("Oops! Page not found.");
    }

    public function show401Action()
    {
        $this->flash->warning("Oops! Your are unauthorized to access this page");
    }

    public function show500Action()
    {
        $this->flash->error("Oops! Something went wrong.");
    }
}
