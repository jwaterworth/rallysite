<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of AdminPageController
 *
 * @author James
 */
class AdminPageController extends PageController {
    
    private $event;
    
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
    }
    
    public function GetPageData() {
        $bookingData = LogicFactory::CreateObject("Bookings");
        $activityData = LogicFactory::CreateObject("Activities");
        $activityData = new Activities();
        
        //Event Information
        $this->data['eventID'] = $this->event->getId();
        $this->data['eventName'] = $this->event->getName();
        $this->data['eventSummary'] = $this->event->getSummary();
        $this->data['eventInfo'] = $this->event->getInformation();
        $this->data['eventLogo'] = $this->event->getLogoLoc();
        
        //Booking Information
        try {  
            
            $bookingInfo = $bookingData->GetBookingInfo($this->event);
            $this->data['bookingInfoID'] = $bookingInfo->getId();
            $this->data['bookingSummary'] = $bookingInfo->getBookingSummary();
            $this->data['bookingInfo'] = $bookingInfo->getBookingInfo();
            
            //Get fees
            $fees = $bookingData->GetFees($bookingInfo);
            $arrFees = array();
            
            foreach($fees as $feeVO) {
                $fee = array();
                $fee['id'] = $feeVO->getId();
                $fee['fee'] = $feeVO->getFee();
                $fee['deadline'] = $feeVO->getDeadline();
                
                $arrFees[] = $fee;
            }
            
            $this->data['bookingFees'] = $arrFees;
            
        } catch (Exception $e) {
            $this->data['bookinginfoID'] = null;
        }
        
        //Activity Page
        try {
            $activityPage = $activityData->GetActivitiesPage($this->event);
            
            $this->data['activityPageID'] = $activityPage->getId();
            $this->data['activityPageBrief'] = $activityPage->getActivitiesBrief();
            
            /*$activities = $activityData->GetAllActivities($activityPage);
            
            $arrActivities = array();
            
            foreach($activities as $activityVO) {
                $activityVO = ActivityFactory::CreateValueObject();
                
                $activity = array();
                
                $activityVO->
            }*/
        } catch (Exception $e) {
            $this->data['activityPageID'] = null;
        }
        
        //Download links
        try {
            $activityPage = $activityData->GetActivitiesPage($this->event);
            $activities = $activityData->GetAllActivities($activityPage);
                        
            $arrActivities = array();
            
            foreach($activities as $activityVO) {
                $activityNumber = $activityData->GetActivityNumber($activityVO);
                if($activityNumber > 0) {
                    $activity = array();
                    
                    $activity['id'] = $activityVO->getId();
                    $activity['name'] = $activityVO->getActivityName();
                    $activity['number'] = $activityNumber;
                    
                    $arrActivities[] = $activity;
                }
            }
            
            $this->data['activity_downloads'] = $arrActivities;
            
        } catch (Exception $e) {
            $this->data['activity_downloads'] = null;
        }
        
    }
    
    public function SaveNewsPost($title, $body) {
        
        //Authenticate user
        if(!$this->CheckAuth(EVENTEXEC, false) ) {
            echo $this->errorMessage = "An error occured authenticating account, please log in and try again";
            return;
        }
        
        $userID = Authentication::GetLoggedInId();
        
        $newsData = LogicFactory::CreateObject("News");
        $newsPost = NewsPostFactory::CreateValueObject();
        
        //Save values into value object after sanitation
        $newsPost->setNewsTitle($title);
        $newsPost->setNewsBody($body);
        //Get date
        $arrDate = getdate();
        $newsPost->setNewsTimeStamp($arrDate['year'] . '-' . $arrDate['mon'] . '-' . $arrDate['mday']);
        //User and event
        $newsPost->setUserID($userID);
        $newsPost->setEventID($this->event->getId());
            
        //Attempt to save news post
        try {
            $newsData->SaveNewsPost($newsPost);
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }
        
        return true;
    }
    
    public function SaveEventInfo($id, $name, $summary, $info, $imagePath, $bookingInfoID, $activityPageID) {
        
        //Authenticate user
        if(!$this->CheckAuth(EVENTEXEC, false) ) {
            echo $this->errorMessage = "An error occured authenticating account, please log in and try again";
            return;
        }
        
        $eventData = LogicFactory::CreateObject("Event");
        $event = EventFactory::CreateValueObject();
        
        //Use current event ID
        $event->setId(htmlspecialchars($id, ENT_NOQUOTES));
        $event->setName(htmlspecialchars($name, ENT_NOQUOTES));
        $event->setSummary($summary);
        $event->setInformation($info);
        $event->setLogoLoc(htmlspecialchars($imagePath, ENT_NOQUOTES));
        $event->setActivityPageID(htmlspecialchars($activityPageID, ENT_NOQUOTES));
        $event->setBookingInfoID(htmlspecialchars($bookingInfoID, ENT_NOQUOTES));
        
        try {
            $eventData->SaveEvent($event);
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }
    }
    
    public function SaveBookingInfo($id, $summary, $info) {
        //Authenticate user
        if(!$this->CheckAuth(EVENTEXEC, false) ) {
            echo $this->errorMessage = "An error occured authenticating account, please log in and try again";
            return;
        }
        
        $bookingInfoData = LogicFactory::CreateObject("Bookings");
        $bookingInfo = BookingInfoFactory::CreateValueObject();
        
        $bookingInfo->setId(htmlspecialchars($id, ENT_NOQUOTES));
        $bookingInfo->setBookingSummary(htmlspecialchars($summary, ENT_NOQUOTES));
        $bookingInfo->setBookingInfo(htmlspecialchars($info, ENT_NOQUOTES));
        
        try {
            $bookingInfoData->SaveBookingInfo($bookingInfo);
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }
    }
    
    public function SaveActivityPage($id, $brief) {
        //Authenticate user
        if(!$this->CheckAuth(EVENTEXEC, false) ) {
            echo $this->errorMessage = "An error occured authenticating account, please log in and try again";
            return;
        }
        
        $activityPageData = LogicFactory::CreateObject("Activities");
        
        $activityPage = ActivityPageFactory::CreateValueObject();
        
        $activityPage->setId(htmlspecialchars($id, ENT_NOQUOTES));
        $activityPage->setActivitiesBrief(htmlspecialchars($brief, ENT_NOQUOTES));
        
        try {
            $activityPageData->SaveActivityPage($activityPage);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function SaveActivity($activityPageID, $name, $description, $capacity, $cost, $imageName) {
        //Authenticate user
        if(!$this->CheckAuth(EVENTEXEC, false) ) {
            echo $this->errorMessage = "An error occured authenticating account, please log in and try again";
            return;
        }
        $activityData = LogicFactory::CreateObject("Activities");
        
        $activity = ActivityFactory::CreateValueObject();
        
        $activity->setActivityPageID(htmlspecialchars($activityPageID, ENT_NOQUOTES));
        $activity->setActivityName(htmlspecialchars($name, ENT_NOQUOTES));
        $activity->setActivityDescription(htmlspecialchars($description, ENT_NOQUOTES));
        $activity->setActivityCost(htmlspecialchars($cost, ENT_NOQUOTES));
        $activity->setActivityCapacity(htmlspecialchars($capacity, ENT_NOQUOTES));
        
		if($imageName != null) {
			$imageLoc = ACTIVITY_IMAGES . $imageName;
			$activity->setActivityImageLoc(htmlspecialchars($imageLoc));
		}        
        
        try {
            $activityData->SaveActivity($activity);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function PushFile($fileType, $id = 0) {
        //Authenticate user
        if(!$this->CheckAuth(EVENTEXEC, false) ) {
            echo $this->errorMessage = "An error occured authenticating account, please log in and try again";
            return;
        }
        
        //Create CSV file
        $csvGenerator = new CSVGenerator($this->event);
        
        switch($fileType) {
            case PARTICIPANT_LIST:
                $fileName = $csvGenerator->CreateParticpantsCSV();
                break;
            case ACTIVITY_LIST:
                $fileName = $csvGenerator->CreateActivityListCSV($id);
                break;
            case CATERING_LIST:
                return;
            default:
                return false;
        }
        
        //Push to browser
        ob_start('ob_gzhandler');
        header('Content-type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        readfile(DOWNLOADS_PATH.$fileName);
        
        return true;
    }

}

?>