<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of ActivityPageController
 *
 * @author Bernard
 */
class ActivityPageController extends PageController{
    
    function __construct($eventID) {
        $this->data = array();
        
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
        
        $activityData = LogicFactory::CreateObject("Activities");
        $activityData = new Activities();
        
        try {
            //Get page and activity data
            $activityPage = $activityData->GetActivitiesPage($event);
            $activityVOs = $activityData->GetAllActivities($activityPage);
            
            //Set page data
            $this->data['pageID'] = $activityPage->getId();
            $this->data['brief'] = $activityPage->getActivitiesBrief();

            //Create array to hold activities
            $arrActivities = array();

            //Add each activity to activities array
            foreach($activityVOs as $activityVO) {
                $activity = array();

                $activity['id'] = $activityVO->getId();
                $activity['name'] = $activityVO->getActivityName();
                $activity['description'] = $activityVO->getActivityDescription();
                $activity['capacity'] = $activityVO->getActivityCapacity() > 0 ? $activityVO->getActivityCapacity() : "Unlimited";
                $activity['cost'] = $activityVO->getActivityCost();
                $activity['imageLoc'] = $activityVO->getActivityImageLoc();
                
                $activity['spacesTaken'] = $activityData->GetActivityNumber($activityVO);

                $arrActivities[] = $activity;
            }
            
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return;
        }
        
        
        
        //Add array of activities to data array
        $this->data['activities'] = $arrActivities;
    }

}

?>
