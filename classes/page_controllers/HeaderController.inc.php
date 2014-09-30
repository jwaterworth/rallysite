<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of HeaderController
 *
 * @author Bernard
 */
class HeaderController extends PageController {
    
    function __construct($eventID) {
        $this->data = array();
        
        $eventData = LogicFactory::CreateObject("Event");
        
        try {
            $event = $eventData->getEvent($eventID);
            $this->event = $event;
            $this->data['eventID'] = $event->getId();
            $this->data['eventName'] = $event->getName();
			$this->data['eventStartDate'] = $event->getStartDate();
			$this->data['eventEndDate'] = $event->getEndDate();
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return;
        }
        
        $this->data['loggedin'] = null;
        if($this->CheckAuth(ALLTYPES, false)) {
            $userID = Authentication::GetLoggedInId();
            $accountData = LogicFactory::CreateObject("Accounts");
            try {
                $account = $accountData->GetAccount($userID);
                if($accountData->GetMemberType($account)->getId() & CLUBREP) {
                    $club = $accountData->GetMemberClub($account);
                    $this->data['club'] = $club->getName();
                }
            } catch(Exception $e) {
			echo $e->getMessage();
                $this->errorMessage = $e->getMessage();
                return;
            }
            $this->data['loggedin'] = 'true';
			
            $this->data['name'] = $account->getName();
        } else {
            $this->data['loggedin'] = null;
        }
    }

}

?>
