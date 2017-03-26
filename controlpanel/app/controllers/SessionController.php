<?php

/**
 * SessionController
 *
 * Allows to authenticate users
 */
class SessionController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Register an authenticated user into session data
     *
     * @param Users $user
     */
    private function _registerSession(CPUsers $user)
    {
        $this->session->set('auth', array(
            'id' => $user->id,
            'username' => $user->username
        ));
    }

    /**
     * This action authenticate and logs an user into the application
     *
     */
    public function startAction()
    {
	    if ($this->request->isPost()) {
        	$username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
		
		    if(empty($username) || empty($password)){
			    $this->flash->error('Type your username & password');
			    return $this->forward('index');
		    }

            $user = CPUsers::findFirst(array(
          		    	"username = :username: AND password = :password:",
	  	          	    'bind' => array('username' => $username, 'password' => md5($password))
                    ));

           	if ($user != false) {
			    $user->last_activity = date("Y-m-d H:i:s");
			    if ($user->save() == false) {
				    $this->flash->error($user->getMessages());
				    return $this->forward('index');
			    }
			    $this->_registerSession($user);
                	$this->flash->success('Welcome ' .ucfirst($user->username));
                	return $this->forward('index');
            }
            $this->flash->error('Wrong email/password');
        }
        return $this->forward('index');
    }

    /**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function endAction()
    {
        $this->session->remove('auth');
        return $this->forward('index/index');
    }
}
