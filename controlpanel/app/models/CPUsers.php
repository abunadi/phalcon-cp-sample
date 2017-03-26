<?php
use Phalcon\Mvc\Model;
class CPUsers extends Model
{
	public $id;
    public $username;
	public $email;
	public $last_activity;
		
	public function getSource()
    {
        return "cp_users";
    }
    
	public function validation()
    {
    	
	}
}
