<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");
/**
 * Description of Open Session. This object type tracks whether a user who is claimed to be logged in is actually currently logged in. 
 * This can help prevent session hijacking
 *
 * @author James
 */
class OpenSessionVO implements IValueObject{
    /*
     * @var $userID int
     * Unique ID number for account
     */
    private $id;
	/*
	 * Account ID
	 */
	private $accountId;
	/*
	 * Session ID. Stores the ID of the session...naturally
	 */
	private $sessionId;
	/*
	 * Token . Generated whilst logging in
	 */
	private $token;
	
    /*
     * Database column names
     */
    public static $dbId ="id";
	public static $dbAccountId ="accountID";
	public static $dbSessionId ="sessionID";
	public static $dbToken ="token";
	    
    public function setId($id) {
        $this->id = (int)$id;
    }
	
	public function setAccountId($accountId) {
        $this->accountId = $accountId;
    }
	
	public function setSessionId($sessionId) {
        $this->sessionId = $sessionId;
    }
	
	public function setToken($token) {
        $this->token = $token;
    }
		
    public function getId() {
        return $this->id;
    }
	
	public function getAccountId() {
        return $this->accountId;
    }
	
	public function getSessionId() {
        return $this->sessionId;
    }
	
	public function getToken() {
        return $this->token;
    }
}

?>
