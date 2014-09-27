<?php

/**
 * Description of PageController
 *
 * @author Bernard
 */
abstract class PageController {
    
    public $data;
    
    public $errorMessage;
    
    protected $displayLogin;
    
    protected $auth;
    
    protected $options;

    
    public function CheckAuth($userLevel, $displayLogin = true) {
	/*
        $this->options = array(
            'dsn' => 'mysql://cojw3:frp73bnk@co-project.lboro.ac.uk/cojw3',
            'table' => 'Account',
            'usernamecol' => 'email',
            'passwordcol' => 'password',
            'cryptType' => 'sha1',
            'db_fields' => '*');

        // Create the Auth object:
        $this->auth = new Auth('DB', $this->options, 'PageController::show_custom_form', $displayLogin);
        $this->auth->setExpire(1000);
        // Start the authorization:
        $this->auth->start();
        
        $loggedIn = $this->auth->checkAuth();
        
        if($loggedIn && ($userLevel & $this->auth->getAuthData('accountTypeID'))) {
            return true;
        }
        */
        //If cases not met, always return false;
		
		$result = Authentication::CheckAuthenticationLevel($userLevel);
		
        return $result;
    }

    function show_custom_form() {
        require(COMMON_TEMPLATES."/login.php");
        /*echo '<form method="post" action="">
            <p>Email <input type="text" name="username" /></p>
            <p>Password <input type="password" name="password" /></p>
            <input type="submit" value="Login" />
            </form><br />
            ';*/
    }
}



?>
