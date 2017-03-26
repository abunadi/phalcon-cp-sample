<?php
use Phalcon\Mvc\User\Plugin;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;

class Logs extends Plugin
{
	private $loggers = array();// array('db' => db_log_path)
	private $user 	 = null;

	public function __construct($loggers = array())
        {
		if(is_array($loggers)){
			foreach($loggers as $logger => $path){
				$this->loggers[$logger] = new FileAdapter($path);		
				// Start a transaction
				$this->loggers[$logger]->begin();
			}
		}	
		else
			exit("Logger accept array only, ex: array('db' => db_log_path).");
        }	

	public function __destruct()
	{
		if(is_array($this->loggers)){
                        foreach($this->loggers as $logger)
                                $logger->commit();
                }
	}

	public function log($logger, $log_message, $log_type = Logger::INFO)
	{
		if(isset($this->loggers[$logger]))
			$this->loggers[$logger]->log($this->getUser() . $log_message, $log_type);
		else
			exit("This logger ($logger) is not exsit yet.");
	}

	private function getUser()
	{
                if(is_null($this->user) && $this->session->has('auth')){
                        $this->user = $this->session->auth['username'];
                }
                return 'user ('.$this->user.'): ';
        }
}
