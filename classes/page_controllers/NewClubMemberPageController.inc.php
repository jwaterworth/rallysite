<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of RegisterPageController
 *
 * @author James
 */
class NewClubMemberPageController extends PageController {
		
	function __construct($eventId, $userId = null) {
        
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
		
        if(!$this->CheckAuth(CLUBREP, false)) {
            $this->data['account'] = null;
            $this->data['edit'] = false;
            return;
        }
        		
        $accountData = LogicFactory::CreateObject("Accounts");
        $accountData = new Accounts();
		
		$id =Authentication::GetLoggedInId();
		$currAccount = $accountData->GetAccount($id);
		$club = $accountData->GetMemberClub($currAccount);
		
		$this->data['clubId'] = $club->getId();
		$this->data['clubName'] = $club->getName();
		
        if($userId) {
			$this->data['edit'] = true;
			
			try {
            $accountVO = AccountFactory::CreateValueObject();
            $accountVO = $accountData->GetAccount($userId);
            
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
		
		} else {
			$this->data['edit'] = false;
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
	
	public function SaveNewAccount($name, $email, $password, $phone, $address, $dob, $medicalCond, $dietaryReq,
            $emergName, $emergRel, $emergPhone, $emergAddress) {
        
        if($this->CheckAuth(CLUBREP, false)) {
		
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
			$accountVO->setClubId($this->data['clubId']);	
			$accountVO->setAccountTypeID(MEMBER);
			
			$result = Authentication::CreateAccount($accountVO, $password);
			
			if($result) {
				//Send email updates
				$emailer = new Email();
				$emailer->SendRegistrationEmail($email);
				return true;
			} else {
				$this->errorMessage =  "Error creating account, please try again";
				return false;
			}    

			return false;
        }
    }
	
	 public function UpdateAccount($id, $name, $email, $phone, $address, $dob, $medicalCond, $dietaryReq,
            $emergName, $emergRel, $emergPhone, $emergAddress) {
        
		if($this->CheckAuth(CLUBREP, false)) {
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
			try {
				$accountData->SaveAccount($account);
				return true;
			} catch(Exception $e) {
				$this->errorMessage = $e->getMessage();
				return false;
			}
		} else {	
			$this->errorMessage = "Only Club Representatives may update other accounts";
			return false;
		}
    }
}