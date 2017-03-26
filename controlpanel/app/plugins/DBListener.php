<?php

use Phalcon\Mvc\User\Plugin;
use Phalcon\Db\Profiler;

class DBListener extends Plugin
{
    protected $_profiler;

    /**
     * Creates the profiler and starts the logging
     */
    public function __construct()
    {
        $this->_profiler = new Profiler();
    }

    /**
     * This is executed if the event triggered is 'beforeQuery'
     */
    public function beforeQuery($event, $connection)
    {
        $this->_profiler->startProfile($connection->getSQLStatement());
        $this->logger->log('db', $connection->getSQLStatement());
    }

    /**
     * This is executed if the event triggered is 'afterQuery'
     */
    public function afterQuery($event, $connection)
    {
        $this->_profiler->stopProfile();
    }

    public function getProfiler()
    {
        return $this->_profiler;
    }
}
