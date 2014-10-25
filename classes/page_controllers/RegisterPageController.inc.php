<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of RegisterPageController
 *
 * @author James
 */
class RegisterPageController extends PageController{
    
    function __construct($eventId) {
        
		//Even though account manipulation is agnostic of event id. We need to maintain the event the user is on
		$eventData = LogicFactory::CreateObject("Event");
		
		 try {
            $event = $eventData->getEvent($eventId);
            $this->event = $event;
            $this->data['eventID'] = $event->getId();
            $this->data['eventName'] = $event->getName();
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return;
        }
		
        if(!$this->CheckAuth(ALLTYPES, false)) {
            $this->data['account'] = null;
            $this->data['edit'] = false;
            return;
        }
        		
        $accountData = LogicFactory::CreateObject("Accounts");
        $accountData = new Accounts();
        
        $this->data['edit'] = true;
        
        try {
            $accountVO = AccountFactory::CreateValueObject();
            $accountVO = $accountData->GetAccount(Authentication::GetLoggedInId());
            
            $account['id'] = htmlspecialchars($accountVO->getId());
            $account['name'] = htmlspecialchars($accountVO->getName());
            $account['number'] = htmlspecialchars($accountVO->getPhoneNumber());
            $account['email'] = htmlspecialchars($accountVO->getEmail());
            $account['address'] = htmlspecialchars($accountVO->getAddress());
            $account['dob'] = htmlspecialchars($accountVO->getDateOfBirth());
            $account['emergName'] = htmlspecialchars($accountVO->getEmergName());
            $account['emergPhone'] = htmlspecialchars($accountVO->getEmergPhone());
            $account['emergAddress'] = htmlspecialchars($accountVO->getEmergAddress());
			$account['emergRelationship'] = htmlspecialchars($accountVO->getEmergRelationship());
            $account['dietaryReq'] = htmlspecialchars($accountVO->getDietaryReq());
            $account['medicalCond'] = htmlspecialchars($accountVO->getMedicalConditions());
            
            $this->data['account'] = $account;
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }
    
    public function GeneratePageData() {
        $accountData = LogicFactory::CreateObject("Accounts");

        try {
            $clubs = $accountData->GetAllClubs();
            
            $arrClubs = array();
            foreach($clubs as $clubVO) {
                $club = array();
                
                $club['id'] = $clubVO->getId();
                $club['name'] = $clubVO->getName();
                $club['logoLoc'] = $clubVO->getLogoLoc();
                
                $arrClubs[] = $club;
            }
            
            $this->data['clubs'] = $arrClubs;
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return;
        }
    }
    
    public function SaveAccount($name, $email, $password, $phone, $address, $dob, $medicalCond, $dietaryReq,
            $emergName, $emergRel, $emergPhone, $emergAddress, $clubID) {
        
		$result = false;
		
        if($this->CheckAuth(ALLTYPES, false)) {
            $id =Authentication::GetLoggedInId();
            $result = $this->UpdateAccount($id, $name, $email, $phone, $address, $dob, $medicalCond, $dietaryReq,
            $emergName, $emergRel, $emergPhone, $emergAddress);
            
        } else {
            $result = $this->SaveNewAccount($name, $password, $email, $phone, $address, $dob, $medicalCond, $dietaryReq,
                    $emergName, $emergRel, $emergPhone, $emergAddress, $clubID);
        }
        
        return $result;
    }
    
    private function UpdateAccount($id, $name, $email, $phone, $address, $dob, $medicalCond, $dietaryReq,
            $emergName, $emergRel, $emergPhone, $emergAddress) {
        
		if($this->CheckAuth(ALLTYPES, false)) {
		
			$loginValidation = $this->ValidateLoginDetails($email, null, false);
			
			if($loginValidation != null) {
				$this->errorMessage = $loginValidation;
				return false;
			}
		
			$validation = $this->ValidateAccountDetails($name, $phone, $address, $dob, $medicalCond, $dietaryReq,
            $emergName, $emergRel, $emergPhone, $emergAddress, null, false);
			
			if($validation != null) {
				$this->errorMessage = $validation;
				return false;
			}
			
			try {
			$accountData = LogicFactory::CreateObject("Accounts");
			$account = AccountFactory::CreateValueObject();
			$account = $accountData->GetAccount($id);
			
			$account->setName($name);
			$account->setEmail($email);
			$account->setPhoneNumber($phone);
			$account->setAddress($address);
			$account->setDateOfBirth($dob);
			$account->setMedicalConditions($medicalCond);
			$account->setDietaryReq($dietaryReq);
			$account->setEmergName($emergName);
			$account->setEmergPhone($emergPhone);
			$account->setEmergAddress($emergAddress);        
			$account->setEmergRelationship($emergRel); 
			
				$accountData->SaveAccount($account);
				return true;
			} catch(Exception $e) {
				$this->errorMessage = $e->getMessage();
				return false;
			}
		}
		 else {
			$this->errorMessage = "You are not logged in.";
		 }
		
		return false;
    }
    
    private function SaveNewAccount($name, $password, $email, $phone, $address, $dob, $medicalCond, $dietaryReq,
            $emergName, $emergRel, $emergPhone, $emergAddress, $clubId) {
        
		$loginValidation = $this->ValidateLoginDetails($email, $password);
		
		$validation = $this->ValidateAccountDetails($name, $phone, $address, $dob, $medicalCond, $dietaryReq,
            $emergName, $emergRel, $emergPhone, $emergAddress);
			
		if($loginValidation != null) {
			$this->errorMessage = $loginValidation;
			return false;
		}
		
		if($validation != null) {
			$this->errorMessage = $validation;
			return false;
		}

		$accountVO = AccountFactory::CreateValueObject();
		//No need to set password in the objet just yet as it needs hashing and salting
		$accountVO->setName($name);
		$accountVO->setEmail($email);
		$accountVO->setPhoneNumber($phone);
		$accountVO->setAddress($address);
		$accountVO->setDateOfBirth($dob);
		$accountVO->setMedicalConditions($medicalCond);
		$accountVO->setDietaryReq($dietaryReq);
		$accountVO->setEmergName($emergName);
		$accountVO->setEmergPhone($emergPhone);
		$accountVO->setEmergAddress($emergAddress);
		$accountVO->setEmergRelationship($emergRel);
		$accountVO->setClubId($clubId);	
		$accountVO->setAccountTypeID(MEMBER);
		
		$result = Authentication::CreateAccount($accountVO, $password);
		
        if($result) {
            //Send email updates
            //$emailer = new Email();
            //$emailer->SendRegistrationEmail($email);
			return true;
        } else {
            $this->errorMessage =  "Error creating account, please try again";
            return false;
        }    

		return false;
    }
	
	private function ValidateLoginDetails($email, $password, $create = true) {
		$valid = true;
		$messages = array();	
		$errorString = null;
		
		//Email
		if(!$this->CheckSet($email)) { $valid = false; $messages[] = "Please enter an email address"; }
		if(!$this->CheckEmail($email)) { $valid = false; $messages[] = "Please enter a valid email address"; }
			
		//Password
		if($create && !$this->CheckSet($password)) { $valid = false; $messages[] = "Please enter a password"; }
		if($create && !$this->CheckLength($password, 5, 50)) {  $valid = false; $messages[] = "Please enter a password of at least 5 characters"; }
		
		if(!$valid) {
			$errorString = implode(". ", $messages);
		}
		
		return $errorString;
	}
	
	private function ValidateAccountDetails($name, $phone, $address, $dob, $medicalCond, $dietaryReq,
            $emergName, $emergRel, $emergPhone, $emergAddress, $create = true) {
	
		$valid = true;
		$messages = array();	
		$errorString = null;
				
	  //Name	
		if(!$this->CheckSet($name)) { $valid = false; $messages[] = "Please enter a name"; }
		if(!$this->CheckLength($name, 4, 50)) { $valid = false; $messages[] = "Please enter a name between 4 and 50 characters"; }
		
		//Phone
		if(!$this->CheckSet($phone)) { $valid = false; $messages[] = "Please enter a phone number"; }
		if(!$this->CheckPhoneNumber($phone)) { $valid = false; $messages[] = "Please enter a UK phone number of 11 digits"; }
		
		//Address
		if(!$this->CheckSet($address)) { $valid = false; $messages[] = "Please enter an address"; }
		if(!$this->CheckLength($address, 5, 255)) { $valid = false; $messages[] = "Please enter an address of at least 5 characters"; }
		
		//Dob
		if(!$this->CheckSet($name)) { $valid = false; $messages[] = "Please enter a date of birth"; }
		if(!$this->CheckDate($dob)) { $valid = false; $messages[] = "Please enter a valid date of birth (dd/mm/yyyy)"; }
		
		//Medical conditions - Only need max length here
		if($medicalCond && strlen($medicalCond) > 500) { $valid = false; $messages[] = "Maximum length reached for medical conditions"; }
		
		//Dietary requirements
		if($dietaryReq && strlen($dietaryReq) > 500) { $valid = false; $messages[] = "Maximum length reached for dietary requirements"; }
		
		//Emnergency Name	
		if(!$this->CheckSet($emergName)) { $valid = false; $messages[] = "Please enter an emergency contact name"; }
		if(!$this->CheckLength($emergName, 4, 50)) { $valid = false; $messages[] = "Please enter an emergency contact name of at least 4 characters"; }

		//Emnergency Relative	
		if(!$this->CheckSet($emergRel)) { $valid = false; $messages[] = "Please enter emergency contact relationship"; }
		if(!$this->CheckLength($emergRel, 4, 50)) { $valid = false; $messages[] = "Please enter an emergency contact relative name of at least 4 characters"; }
		
		//Emergency PHone
		if(!$this->CheckSet($emergPhone)) { $valid = false; $messages[] = "Please enter an emergency phone number"; }
		if(!$this->CheckPhoneNumber($emergPhone)) { $valid = false; $messages[] = "Please enter a UK emergency phone number of 11 digits"; }
		
		//Emergency Address
		if(!$this->CheckSet($emergAddress)) { $valid = false; $messages[] = "Please enter an emergency address"; }
		if(!$this->CheckLength($emergAddress, 5, 255)) { $valid = false; $messages[] = "Please enter an emergency address of at least 5 characters"; }
		
		
		if(!$valid) {
			$errorString = implode(". ", $messages);
		}
		
		return $errorString;
	}
	
	private function CheckDate($value) {
		$dateComponents = explode("/", $value);
		if(count($dateComponents) != 3) {
			return false;
		} else if($dateComponents[0] < 1 || $dateComponents[0] > 31){
			return false;
		} else if($dateComponents[1] < 1 || $dateComponents[1] > 12){
			return false;
		}	else if($dateComponents[2] < 1900 || $dateComponents[2] > 2015){
			return false;
		}			
		return true;		
	}
	
	private function CheckEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	private function CheckSet($value) {
		return $value != null && $value != "";
	}
	
	private function CheckLength($value ,$min, $max) {
		return strlen($value) >= $min && strlen($value) <= $max;	
	}
	
	private function CheckPhoneNumber($value) {
		$noSpaces = str_replace(' ', '', $value);		
		return preg_match('/^\d+$/',$noSpaces) && $this->CheckLength($noSpaces, 11, 11);		
	}
}

?>
