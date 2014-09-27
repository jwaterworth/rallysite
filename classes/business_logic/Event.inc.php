<?php
require_once(BUSLOGIC_PATH."/BusinessLogic.inc.php");
/**
 * Description of Event_Info
 *
 * @author James
 */
class Event extends BusinessLogic{
       
    public function GetEvent($id) {
        $dbEventInfo = EventFactory::GetDataAccessObject();
        
        $event = $dbEventInfo->GetById($id);
        
        if($event == null) {
            throw new Exception("Event does not exist");
        }
        
        return $event;
    }
    
    public function SaveEvent(EventVO $event) {
        $dbEvent = EventFactory::GetDataAccessObject();
        
        if(!$dbEvent->Save($event)) {
            throw new Exception("An error occured saving" . $event->getName());
        }
        
        return true;
    }
}

?>
