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
