<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of HomepageController
 *
 * @author James
 */
class HomepageController extends PageController {
    
    public function __construct($eventID) {
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
        
        $newsData = LogicFactory::CreateObject("News");
        $activityData = LogicFactory::CreateObject("Activities");
        $activityData = new Activities();
        
        
        $this->data['eventID'] = $event->getId();
        
        //News Posts
        try {
            $newsPosts = $newsData->GetAllNews($event);
            
            $arrNewsPosts = array();
            
            foreach($newsPosts as $newsPostVO) {
                $newsPost = array();
                $newsPost['newsId'] = $newsPostVO->getId();
                $newsPost['title'] = $newsPostVO->getNewsTitle();
                $newsPost['author'] = $newsData->GetNewsAuthor($newsPostVO);
                $newsPost['timestamp'] = $newsPostVO->getNewsTimeStamp();
                $newsPost['body'] = $newsPostVO->getNewsBody();

                $arrNewsPosts[] = $newsPost;
            }
            
            $this->data['newsPosts'] = $arrNewsPosts;
            
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return;
        }    
        
        // Activities
        try {
            $activityPage = $activityData->GetActivitiesPage($event);
            $activities = $activityData->GetRandomActivities($activityPage, 3);
            
            $this->data['activityError'] = null;
            
            $arrActivities = array();
            foreach($activities as $activityVO) {
                $activity = array();
                
                $activity['id'] = $activityVO->getId();
                $activity['name'] = $activityVO->getActivityName();
                $activity['imgLoc'] = $activityVO->getActivityImageLoc();
                
                $arrActivities[] = $activity;
            }
            
            $this->data['activities'] = $arrActivities;
        } catch (Exception $e) {
            $this->data['activityError'] = $e->getMessage();
        }
        
    }

}

?>
