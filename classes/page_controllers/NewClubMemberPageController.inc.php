<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of RegisterPageController
 *
 * @author James
 */
class NewClubMemberPageController extends PageController {
		
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
		
        
        $this->data['edit'] = false;
        /*
        try {
            $accountVO = AccountFactory::CreateValueObject();
            $accountVO = $accountData->GetAccount(Authentication::GetLoggedInId());
            
            $account['id'] = $accountVO->getId();
            $account['name'] = $accountVO->getName();
            $account['number'] = $accountVO->getPhoneNumber();
            $account['email'] = $accountVO->getEmail();
            $account['address'] = $accountVO->getAddress();
            $account['dob'] = $accountVO->getDateOfBirth();
            $account['emergName'] = $accountVO->getEmergName();
            $account['emergPhone'] = $accountVO->getEmergPhone();
            $account['emergAddress'] = $accountVO->getEmergAddress();
			$account['emergRelationship'] = $accountVO->getEmergRelationship();
            $account['dietaryReq'] = $accountVO->getDietaryReq();
            $account['medicalCond'] = $accountVO->getMedicalConditions();
            
            $this->data['account'] = $account;
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
		*/
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
			$accountVO->setName(htmlspecialchars($name));
			$accountVO->setEmail(htmlspecialchars($email));
			$accountVO->setPhoneNumber(htmlspecialchars($phone));
			$accountVO->setAddress(htmlspecialchars($address));
			$accountVO->setDateOfBirth(htmlspecialchars($dob));
			$accountVO->setMedicalConditions(htmlspecialchars($medicalCond));
			$accountVO->setDietaryReq(htmlspecialchars($dietaryReq));
			$accountVO->setEmergName(htmlspecialchars($emergName));
			$accountVO->setEmergPhone(htmlspecialchars($emergPhone));
			$accountVO->setEmergAddress(htmlspecialchars($emergAddress));
			$accountVO->setEmergAddress(htmlspecialchars($emergRel));
			$accountVO->setClubId(htmlspecialchars($this->data['clubId']));	
			$accountVO->setAccountTypeID(APPROVED);
			
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
}