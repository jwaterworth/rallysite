<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of EventPageController
 *
 * @author Bernard
 */
class EventPageController extends PageController{
    
    function __construct($id) {
        $this->data = array();
        
        $eventData = LogicFactory::CreateObject("Event");
        
        $event = EventFactory::CreateValueObject();
        
        try {
            $event = $eventData->GetEvent($id);
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return;
        }
        
        $this->data['id'] = $event->getId();
        $this->data['name'] = $event->getName();
        $this->data['summary'] = $event->getSummary();
        $this->data['info'] = $event->getInformation();
        $this->data['logoLoc'] = $event->getLogoLoc();
    }

}

?>
