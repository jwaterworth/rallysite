<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of ConfirmationPageController
 *
 * @author James
 */
class ConfirmationPageController extends PageController{
    
    public $confirmationType;
    
    function __construct($eventID, $type = ERROR, $result = false, $errorMessage = null) {
        $this->data = array();
        $this->errorMessage = null;
        
        try {
            $eventData = LogicFactory::CreateObject("Event");
            $event = $eventData->getEvent($eventID);
            $this->data['eventID'] = $event->getId();
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
        
        switch($type) {
            case REGISTRATION:
                $this->data['title'] = "Registration Confirmation";
                $this->confirmationType = REGISTRATION;
                if(!$result) {
                    $this->errorMessage = $errorMessage;
                }
                break;
			case UPDATE_DETAILS:
                $this->data['title'] = "Details Updated";
                $this->confirmationType = UPDATE_DETAILS;
                if(!$result) {
                    $this->errorMessage = $errorMessage;
                }
                break;
			case CLUB_REGISTRATON:
                $this->data['title'] = "Club Member Registered";
                $this->confirmationType = CLUB_REGISTRATON;
                if(!$result) {
                    $this->errorMessage = $errorMessage;
                }
                break;
			case CLUB_MEMBER_UPDATE:
                $this->data['title'] = "Club Member Updated";
                $this->confirmationType = CLUB_MEMBER_UPDATE;
                if(!$result) {
                    $this->errorMessage = $errorMessage;
                }
                break;
            case BOOKING:
               $this->data['title'] = "Booking Confirmation";
                $this->confirmationType = BOOKING;
                if(!$result) {
                    $this->errorMessage = $errorMessage;
                }
                break;
            default:
                $this->data['title'] = 'Confirmations Page';
                $this->errorMessage = 'No activities requiring confirmation detected';
                break;
        }
    }
}

?>
