<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of ParticipantsPageController
 *
 * @author James
 */
class ParticipantsPageController extends PageController{
    
    private $event;
	
	private $totalBooked = 0;
    
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
        $activityData = LogicFactory::CreateObject("Activities");
        $activityData = new Activities();
        
        $bookingData = LogicFactory::CreateObject("Bookings");
        $bookingData = new Bookings();
        
        $accountData = LogicFactory::CreateObject("Accounts");
        $accountData = new Accounts();
        
        try {
            //Get Event activities
            $activityPage = $activityData->GetActivitiesPage($this->event);
            $activities = $activityData->GetAllActivities($activityPage);
            
            $this->data['activities'] = $this->GetActivityDetails($activities, $activityData, $bookingData, $accountData);            
            
			$this->data['total'] = $this->totalBooked;
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
        
    }
    
    private function GetActivityDetails($activities, $activityData, $bookingData, $accountData) {
        //Initialise activity array
        $arrActivities = array();

        //Get activity details, and their participants
        foreach($activities as $activityVO) { //Perhaps only get activity if there are participants?
            $activity = array();
            try {
                $activity['error'] = null;
                $activity['id'] = $activityVO->getId();
                $activity['name'] = $activityVO->getActivityName();
                $activity['imgLoc'] = $activityVO->getActivityImageLoc();
                $activity['capacity'] = $activityVO->getActivityCapacity();
                $activity['number'] = $activityData->GetActivityNumber($activityVO);
				$this->totalBooked += $activityData->GetActivityNumber($activityVO);
                //Get activity participants
                $activityBookings = $activityData->GetActivityParticipants($activityVO);

                //Get participant details
                $activity['participants'] = $this->GetParticipantDetails($activityBookings, $bookingData, $accountData);

                $arrActivities[] = $activity;
            } catch (Exception $e) {
                $activity['error'] = $e->getMessage();
            }
            
        }
        
        return $arrActivities;
    }
    
    private function GetParticipantDetails($activityBookings, $bookingData, $accountData) {
        //Initialise array to hold participants
        $arrBookings = array();

        //Get participant details
        foreach($activityBookings as $bookingVO) {
            $booking = array();
            try {
                $booking['error'] = null;
                $accountVO = $bookingData->GetBookingAccount($bookingVO);
                $booking['accountID'] = $accountVO->getId();
                $booking['accountName'] = htmlspecialchars($accountVO->getName());

                $club = $accountData->GetMemberClub($accountVO);
                $booking['clubID'] = $club->getId();
                $booking['clubName'] = $club->getName();

                $arrBookings[] = $booking;
            } catch (Exception $e) {
                $booking['error'] = $e->getMessage();
                $arrBookings[] = $booking;
            }
        }
 
        return $arrBookings;
    }

}

?>
