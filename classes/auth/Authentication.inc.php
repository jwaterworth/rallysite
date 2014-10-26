<?php

/**
 * Description of Authentication 
 *
 *	Singleton class to control authentication throughout the system
 *
 * @author James
 */
 
 class Authentication {
 
	private static $_siteKey = 'rallysite';
 
	public static function CreateAccount($accountVO, $password) {		
		$result = 0;
		
		$dbAccounts = AccountFactory::GetDataAccessObject();   
		
		//First check the account doesn't already exist
		$accountVOTest = $dbAccounts->GetByEmail($accountVO->getEmail());
		if(count($accountVOTest) == 0) {
			//Generate a salt		
			$userSalt = self::RandomString();
			
			//Salt and hash the password
			$password = $userSalt . $password;
			$accountVO->setPassword(self::HashData($password));
			$accountVO->setUserSalt($userSalt);
			
			//Create the account
			$dbAccounts = AccountFactory::GetDataAccessObject();        
			
			$result = $dbAccounts->Save($accountVO);
		}	
		else {
			$result = 999; //Account exists
		}		
		
        return $result;
	}
	
	public static function Login($email, $password)
	{
		$result = false;
	
		//Set up our database access objects
		$dbAccounts = AccountFactory::GetDataAccessObject();   
		$dbOpenSessions = OpenSessionFactory::GetDataAccessObject();

		//Select users row from database base on $email
		$accountVO = $dbAccounts->GetByEmail($email);
		
		if($accountVO != null) {
			//Salt and hash password for checking
			$password = $accountVO->getUserSalt() . $password;
			$password = self::hashData($password);
				
			//Check email and password hash match database row
			$match = $accountVO->getPassword() == $password;	
				
			if($match == true) {
				//Email/Password combination exists, set sessions
				//First, generate a random string.
				$random = self::randomString();
				//Build the token
				$token = (isset($_SERVER['HTTP_USER_AGENT']) ? isset($_SERVER['HTTP_USER_AGENT']) : "")  . $random;
				$token = self::hashData($token);
					
				//Setup sessions vars					
				if (session_status() == PHP_SESSION_NONE) {
					session_start();
				}
				
				$_SESSION['token'] = $token;
				$_SESSION['account_id'] = $accountVO->getId();
				
				/*
				//Set up the value object for committing to the database
				//$openSessionVO = OpenSessionFactory::CreateValueObject();
				//$openSessionVO->setAccountId($accountVO->getId());
				//$openSessionVO->setSessionId(session_id());
				//$openSessionVO->setToken($token);		
				//Now actually set up the session
				
					
				//Delete old logged_in_member records for user
				try {
					//$dbOpenSessions->DeleteByAccountId($accountVO->GetId());
				} catch(Exception $exception) {
					//Safe to swallow here the record may not exist
				}					
				
				//Insert new logged_in_member record for user
				//$insertedId = $dbOpenSessions->Save($openSessionVO);

				*/
				//Logged in
				//if($insertedId != null) {
					$result = true;
				//} 
			}
		}	
		
		return $result;
	}
	
	public static function Logout() {
		//No need to delete the VO as it's deleted on the next login
		
		//Just in case
		session_start();
		
		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}	
		
		//Just destroy the current session
		session_destroy();		
	}
	
	public static function ChangePassword($newPassword) {
		if(self::CheckAuthenticationLevel(ALLTYPES, false)) {
			
		
		} else {
			throw Exception("Cannot update password as you are not logged in");
		}
	}
	
	public static function CheckAuthenticationLevel($userLevel) {
		//Now we need to check the session to make sure we're all good		
		$accountId = isset($_SESSION['account_id']) ? $_SESSION['account_id'] : null;
			
		//if(self::CheckSession($accountId)) {
		if($accountId) {
			$dbAccounts = AccountFactory::GetDataAccessObject();
			
			$accountVO = $dbAccounts->GetById($accountId);
			return $userLevel & $accountVO->getAccountTypeID();
		} else {
			return false;
		}
	}
	
	public static function GetLoggedInId() {
		return $_SESSION['account_id'];
	}
	
	private static function CheckSession($accountId) {
		$result = false;
		
		if($accountId != null) {
			$dbOpenSessions = OpenSessionFactory::GetDataAccessObject();
			$openSessionVO = null;
			
			//This method always returns an array of results i.e. will be empty if no match
			$openSessionVOArray = $dbOpenSessions->GetByAttribute(OpenSessionVO::$dbAccountId, $accountId);
			
			//Just get the first record
			$openSessionVO = count($openSessionVOArray) > 0 ? $openSessionVOArray[0] : null;
			
			if($openSessionVO != null ) {				
				if(session_id() == $openSessionVO->getSessionId() && $_SESSION['token'] == $openSessionVO->getToken()) {				
					//self::RefreshSession($dbOpenSessions, $openSessionVO);
					$result = true;
				}
			}
		}
		
		return $result;
	}
	
	private static function RefreshSession($dbOpenSessions, $openSessionVO) {
		//Regenerate the session id
		session_regenerate_id();
		
		//Regenerate token
		$random = self::RandomString();
		
		//Build the token
		$token = $_SERVER['HTTP_USER_AGENT'] . $random;
		$token = self::HashData($token);
		
		//Store in session and value object	
		$openSessionVO->setToken($token);
		$openSessionVO->setSessionId(session_id());
		
		$_SESSION['token'] = $token;
		
		//Recommit to database	
		$dbOpenSessions->Save($openSessionVO);
	}
	
 
	private static function RandomString($length = 50)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';    
			
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters) - 1)];
		}
			
		return $string;
	}
	
	private static function HashData($data)
	{
		return hash_hmac('sha512', $data, self::$_siteKey);
	}

 } 
 
 ?>