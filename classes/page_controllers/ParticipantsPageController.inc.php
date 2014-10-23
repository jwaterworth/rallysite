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
    
    public function GetPageData($bookingsType = 1) {	
		
		if($bookingsType == WHOSGOING) {		
			$this->WhosGoing();
		} else if($bookingsType == WHOSDOING) {
			$this->WhosDoing();
		} 
    }
	
	private function WhosGoing() {
		$bookingData = LogicFactory::CreateObject("Bookings");
        $bookingData = new Bookings();
        
        $accountData = LogicFactory::CreateObject("Accounts");
        $accountData = new Accounts();
		
		$totalBookingCount = 0;
		
		try {
			$clubs = $accountData->GetAllClubs();
			
			$this->data["clubs"] = array();
			
			foreach($clubs as $club) {
				$clubBookingArray = array();	
				$clubBookingArray["clubError"] = null;
				$clubBookingCount = 0;
				try {					
					$clubBookingArray["clubName"] = $club->getName();	
					$clubBookingArray["clubBookings"] = array();
					//Get all club bookings in the new composite bookings container
					$clubBookings = $bookingData->getClubBookingsComposite($this->event->getId(), $club->getId());
					
					foreach($clubBookings as $composite) {
						$bookingArray = array();
						
						$bookingArray["accountId"] = $composite->getUserId();
						$bookingArray["accountName"] = $composite->getUserName();
						$bookingArray["bookingId"] = $composite->getBookingId();
						$bookingArray["activityId"] = $composite->getActivityId();
						$bookingArray["activityName"] = $composite->getActivityName();
						
						$clubBookingArray["clubBookings"][] = $bookingArray;
						$clubBookingCount++;
						$totalBookingCount++;
					}		
				
				} catch(Exception $e) {
					$clubBookingArray["clubError"] = $e->getMessage();
				}				
				
				$clubBookingArray["numBookings"] = $clubBookingCount;
				$this->data["clubs"][] = $clubBookingArray;				
			}	
			
			$this->data["total"] = $totalBookingCount;
		} catch(Exception $e) {
			$this->errorMessage = $e->getMessage();
		}
	}
	
	private function WhosDoing() {
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
	
	private function CreateSummary($bookingData, AccountVO $account, BookingVO $booking) {
        //Get user's booking summary
        $activity = $bookingData->GetBookingActivity($booking);

        $summary = array();
        
        $summary['userID'] = htmlspecialchars($account->getId());
        $summary['userName'] = htmlspecialchars($account->getName());
        $summary['bookingID'] = htmlspecialchars($booking->getId());
        $summary['activityID'] = htmlspecialchars($activity->getId());
        $summary['activityName'] = htmlspecialchars($activity->getActivityName());

        return $summary;
    }

}

?>
