<?php

/**
 * Description of AJAXHandler
 *
 * @author James
 */
class AJAXHandler {
    function __construct() {
        
    }

    public function GetAccountDetails($accountID) {
        $accountData = LogicFactory::CreateObject("Accounts");
        $accountData = new Accounts();
        
        $responseString = null;
        
        try {
            $account = AccountFactory::CreateValueObject();
            $account = $accountData->GetAccount($accountID);

            $responseString = $account->getName() . '|' . $account->getEmail() . '|' . $account->getPhoneNumber();
        } catch (Exception $e) {
            $responseString = 'No data found';
        }
        
        echo $responseString;
        
    }
    
    public function GetActivityDetails($activityID) {
        $activityData = LogicFactory::CreateObject("Activities");
        $activityData = new Activities();
        
        $responseString = null;
        
        try { 
            $activity = ActivityFactory::CreateValueObject();
            $activity = $activityData->GetActivity($activityID);
            
            $name = $activity->getActivityName();
            $cost = $activity->getActivityCost();
            
            $number = $activityData->GetActivityNumber($activity);
            $capacity = $activity->getActivityCapacity();
            
            $spaces = $capacity - $number;
            
            $responseString = $name . '|' . '£'.$cost . '|' . $number . '|' . $capacity . '|' . $spaces;
        } catch (Exception $e) {
            $responseString = '0';
        }
         
        echo $responseString;
    }
	
	public function GetClubs() {
		$accountData = LogicFactory::CreateObject("Accounts");
		
		$postData = "";
		
		try {
			$clubs = $accountData->GetAllClubs();
		
			$clubResponseArray = array();
			
			foreach($clubs as $club) {
				$temp = array();			
				$temp["id"] = $club->getId();
				$temp["name"] = $club->getName();			
				$clubResponseArray[] = $temp;
			}
			
			$post_data = json_encode($clubResponseArray);
		} catch(Exception $e) {
			$post_data = "Error: " . $e;
		}
		
		echo $post_data;
	}
	
	public function GetClubBookings($eventId, $clubId) {
		$accountData = LogicFactory::CreateObject("Accounts");
		$bookingData = LogicFactory::CreateObject("Bookings");
		$eventData = LogicFactory::CreateObject("Event");
		
		$postData = "";
		
		try {
			$club = ClubFactory::CreateValueObject();
			$club->setId($clubId);
			$clubAccounts = $accountData->GetClubAccounts($club);
			
			$event = $eventData->GetEvent($eventId);
			$clubBookings = $bookingData->GetClubBookings($event, $club);
			
			$clubBookingSummaries = array();
			
			 //Create a summary for each booking
            foreach($clubBookings as $booking) {
                //Get account for booking
                $account = $bookingData->GetBookingAccount($booking);
                $clubBookingSummaries[] = $this->CreateSummary($bookingData, $account, $booking);   
            }
            
			$post_data = json_encode($clubBookingSummaries);
		} catch(Exception $e) {
			$post_data = "Error: " . $e;
		}
		
		echo $post_data;
	}
	
	private function CreateSummary($bookingData, AccountVO $account, BookingVO $booking) {
		$bookingData = LogicFactory::CreateObject("Bookings");
	
        //Get user's booking summary
        $activity = $bookingData->GetBookingActivity($booking);

        $summary = array();
        
        $summary['userID'] = $account->getId();
        $summary['userName'] = $account->getName();
        $summary['bookingID'] = $booking->getId();
        $summary['fee'] = $booking->getBookingFee();
        $summary['activityID'] = $activity->getId();
        $summary['activityName'] = $activity->getActivityName();
        
        //If statement because paid variable is integer 1 or 0 rather than a boolean
        if($booking->getPaid()) {
            $summary['paid'] = true;
        } else {
            $summary['paid'] = false;
        }

        return $summary;
    }
}

?>
