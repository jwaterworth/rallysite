<?php
require_once(BUSLOGIC_PATH."/BusinessLogic.inc.php");

/**
 * Description of Activities
 *
 * @author James
 */
class Activities extends BusinessLogic {
    
    public function GetActivitiesPage(EventVO $event) {
        $dbActivitiesPage = ActivityPageFactory::GetDataAccessObject();
        
        $activityPage = ActivityPageFactory::CreateValueObject();
        $activityPage = $dbActivitiesPage->GetById($event->getActivityPageID());
        
        if($activityPage == null) {
            throw new Exception("Activity page does not exist");
        }
        
        return $activityPage;
    }
    
    public function GetAllActivities(ActivityPageVO $activityPage) {
        $dbActivities = ActivityFactory::GetDataAccessObject();
        $activities = ActivityFactory::CreateValueObject();
        
        $activities = $dbActivities->GetByForeignKey($activityPage->getId());
         
        if(sizeof($activities) < 1) {
            throw new Exception("No activities associated with this activity page");
        }

        return $activities;
    }
    
    public function GetActivity($activityID) {
        $dbActivities = ActivityFactory::GetDataAccessObject();
        
        $activity = $dbActivities->GetById($activityID);
        
        if($activity == null) {
            throw new Exception("Activity does not exist");
        }
        
        return $activity;
    }
    
    public function SaveActivityPage(ActivityPageVO $activityPage){
        $dbActivityPage = ActivityPageFactory::GetDataAccessObject();
        
        if($dbActivityPage->Save($activityPage) < 1) {
            throw new Exception("An error occured saving activity page");        
        }

        return true;
    }
    
    public function SaveActivity(ActivityVO $activity) {
        $dbActivity = ActivityFactory::GetDataAccessObject();
        
        if($dbActivity->Save($activity) < 1){
            throw new Exception("An error occured saving activity: " .
                    $activity->getActivityName());
        }
        
        return true;
    }
    
    public function GetActivityParticipants(ActivityVO $activity, $priority = 1) {
        $participants = array();
        
        //Data Access Objects
        $dbBookingActivity = BookingActivityFactory::GetDataAccessObject();
        
        //Logic Objects
        $bookings = LogicFactory::CreateObject("Bookings");
        
        $bookingActivities = $dbBookingActivity->GetByAttribute(
                    BookingActivityVO::$dbActivityID, $activity->getId());
        
        foreach($bookingActivities as $bookingActivity) {    
            if($bookingActivity->getPriority() == $priority) {
                $participants[] = $bookings->GetBooking(
                    $bookingActivity->getBookingID());
            }
        }
        
        //May not need as some activities won't have participants!
        /*if(sizeof($participants) < 1) {
            throw new Exception("No participants found for " . $activity->getActivityName());
        }*/
        
        return $participants;
    }
    
    public function GetActivityNumber($activity, $priority = 1) {
        
        $participants = $this->GetActivityParticipants($activity, $priority);
        
        $count = 0;
        
        foreach($participants as $booking) {
            $count++;
        }
        
        return $count;
    }
    
    public function CheckSpace(ActivityVO $activity, $priority = 1) {
        $number = $this->GetActivityNumber($activity, $priority);
        
        $capacity = $activity->getActivityCapacity();
		
        if($capacity == 0 ||$number < $capacity) { //There is space
            return true;
        } else {
            return false;
        }
    }
    
    public function GetRandomActivities(ActivityPageVO $activityPage, $number) {
        
        //Get all activities
        $activities = $this->GetAllActivities($activityPage);
        
        //Filter out full activities
        
        
        //Default number to 2 if number is greater than
        $number > sizeof($activities) || $number < 2 ? $number = 2 : $number;
        
        //Pick $maxResults worth of activities
        $activityKeys = array_rand($activities, $number);
        
        $randActivities = array();
        
        foreach($activityKeys as $activityKey) {
            $randActivities[] = $activities[$activityKey];
        }
        
        if(sizeof($randActivities) < 1) {
            throw new Exception("No random activities could be found");
        }
        
        return $randActivities;
    }
    
}

?>
