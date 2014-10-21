<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of AccountPageController
 *
 * @author James
 */
class AccountPageController extends PageController{
    
    private $userID;
    
    function __construct($eventID) {
        //Even though account manipulation is agnostic of event id. We need to maintain the event the user is on
		$eventData = LogicFactory::CreateObject("Event");
		
		 try {
            $event = $eventData->getEvent($eventID);
            $this->event = $event;
            $this->data['eventID'] = $event->getId();
            $this->data['eventName'] = $event->getName();
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return;
        }
    }
    
    public function GetAccountDetails() {
	
         //Secondary check for member, ensures $auth is set
        if(!$this->CheckAuth(ALLTYPES|UNAPPROVED, false)) {
            $this->errorMessage = ('Please log in to view this page');
            return;
        }      
		
        //Logic Objects
        $accountData = LogicFactory::CreateObject("Accounts");
        
        //Get user ID
        $this->userID = Authentication::GetLoggedInId();
        //Get account details
        try {
            $account = $accountData->GetAccount($this->userID);
            //Personal Details
            $this->data['userID'] = htmlspecialchars($account->getId());
            $this->data['name'] = htmlspecialchars($account->getName());
            $this->data['email'] = htmlspecialchars($account->getEmail());
            $this->data['phone'] = htmlspecialchars($account->getPhoneNumber());
            $this->data['address'] = htmlspecialchars($account->getAddress());
            $this->data['dietaryReq'] = htmlspecialchars($account->getDietaryReq());
            $this->data['medicalCond'] = htmlspecialchars($account->getMedicalConditions());
            
            //Club
            $club = $accountData->GetMemberClub($account);
            $this->data['clubID'] = $club->getId();
            $this->data['clubName'] = $club->getName();
            
            //Account Type
            $accountType = $accountData->GetMemberType($account);
            $this->data['accountTypeID'] = $accountType->getId();
            $this->data['accountTypeName'] = $accountType->getAccountTypeName();
            
            //Past bookings
            
        } catch (Exception $e) {
            //$this->errorMessage = ('An error occured retrieving the account');
            $this->errorMessage = $e->getMessage();
            return false;
        }
        
        //Get past bookings
        
        return true;
    }

}

?>
