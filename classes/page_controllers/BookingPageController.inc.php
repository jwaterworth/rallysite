<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of BookingPageController
 *
 * @author Bernard
 */
class BookingPageController extends PageController{
    
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
       
       //Business logic objects
       $bookingData = LogicFactory::CreateObject("Bookings");
       $accountData = LogicFactory::CreateObject("Accounts");
       
       //Page data
       try {
            //Get booking data
            $bookingInfo = $bookingData->GetBookingInfo($event); 
            
            //Set booking info
            $this->data['infoID'] = $bookingInfo->getId();
            $this->data['infoSummary'] = $bookingInfo->getBookingSummary();
            $this->data['info'] = $bookingInfo->getBookingInfo();
            
            //Set fees
            $fees = $bookingData->GetFees($bookingInfo);
            $arrFees = array();
            
            //Get fees for event
            foreach($fees as $feeVO) {
                $fee = array();
                $fee['feeID'] = $feeVO->getId();
                $fee['fee'] = '£' . $feeVO->getFee();
                $fee['deadline'] = $feeVO->getDeadline();
                
                $arrFees[] = $fee;
            }
            //Add fees to data
            $this->data['fees'] = $arrFees;
            
       } catch (Exception $e) {
           $this->errorMessage = $e->getMessage();
           return;
       }
       
       //Attempt to get personal booking
       $this->GetPersonalBooking($accountData, $bookingData);
       
       //Attempt to get club bookings
       $this->GetClubBookings($accountData, $bookingData);
       
       //Get random activities for advertising
       $this->GetRandomActivities($this->event);
    }
    
    private function GetPersonalBooking($accountData, $bookingData) {

		$this->data['personalBooking'] = null;
		$this->data['bookingAllowed'] = false;
	
        if(!$this->CheckAuth(ALLTYPES, false)) {            
            $this->data['reason'] = "Login to see your booking";
            return;
        } else if(!$this->CheckAuth(MEMBER|CLUBREP|EVENTEXEC|SSAGOEXEC, false)) {
			$this->data['reason'] = "Your account requires approval by a representative from your club. Please contact your club representative to approve your account or create your booking for you.";
			return;
		}
		
		$this->data['bookingAllowed'] = true;
		
        //Personal booking data
        try {
            //Get user's booking summary
            $account = $accountData->GetAccount(Authentication::GetLoggedInId());
            $booking = $bookingData->GetAccountBooking($this->event, $account);

            $this->data['personalBooking'] = $this->CreateSummary($bookingData, $account, $booking);
			
        } catch (Exception $e) {
            $this->data['reason'] = $e->getMessage();
            return;
        }
    }
    
    private function GetClubBookings($accountData, $bookingData) {        
        
        if(!$this->CheckAuth(CLUBREP, false)) {
            $this->data['clubBookings'] = null;
            $this->data['club_reason'] = "";
            return;
        }
 
        try {
            //Get curent users' details
            $userID = Authentication::GetLoggedInId();
            $account = $accountData->getAccount($userID);
            
            //Get club bookings
            $bookings = $bookingData->GetClubBookings($this->event, $accountData->GetMemberClub($account));
            
            $clubBookings = array();
            
            //Create a summary for each booking
            foreach($bookings as $booking) {
                //Get account for booking
                $account = $bookingData->GetBookingAccount($booking);
                $clubBookings[] = $this->CreateSummary($bookingData, $account, $booking);   
            }
            
            $this->data['clubBookings'] = $clubBookings;
            
        } catch (Exception $e) {
            $this->data['clubBookings'] == null;
            $this->data['club_reason'] = $e->getMessage();
            return;
        }             
    }

    private function GetRandomActivities(EventVO $event) {
        $activityData = LogicFactory::CreateObject("Activities");
        $activityData = new Activities();
        
        try {
            $activityPage = $activityData->GetActivitiesPage($event);
            $activities = $activityData->GetRandomActivities($activityPage, 2);
            
            $arrActivities = array();
            
            foreach($activities as $activityVO) {
                $activity = array();
                
                $activity['activityID'] = $activityVO->getId();
                $activity['activityName'] = $activityVO->getActivityName();
                $activity['activityImgLoc'] = $activityVO->getActivityImageLoc();
                
                $arrActivities[] = $activity;
            }
        } catch (Exception $e) {
            $this->data['activities'] = null;
            $this->data['activity_error'] = $e->getMessage();
        }
        
        $this->data['activities'] = $arrActivities;
        
    }
    
    private function CreateSummary($bookingData, AccountVO $account, BookingVO $booking) {
        //Get user's booking summary
        $activity = $bookingData->GetBookingActivity($booking);

        $summary = array();
        
        $summary['userID'] = htmlspecialchars($account->getId());
        $summary['userName'] = htmlspecialchars($account->getName());
        $summary['bookingID'] = htmlspecialchars($booking->getId());
        $summary['fee'] = '£' . htmlspecialchars($booking->getBookingFee());
        $summary['activityID'] = htmlspecialchars($activity->getId());
        $summary['activityName'] = htmlspecialchars($activity->getActivityName());
		$summary['paid'] = $booking->getPaid() ? "Paid" : "Awaiting Payment";

        return $summary;
    }
    
    
}

?>
