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

            $responseString = htmlspecialchars($account->getName()) . '|' . htmlspecialchars($account->getEmail()) . '|' . htmlspecialchars($account->getPhoneNumber());
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
	
	//Start of new web service methods
	
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
	
	public function GetActivities($eventId) {
		$post_data = "";
	
		$eventData = LogicFactory::CreateObject("Event");
		$activityData = LogicFactory::CreateObject("Activities");
		try {
			$event = $eventData->GetEvent($eventId);
			
			//Get the activity page containing all activities for this event
			$activityPage = $activityData->GetActivitiesPage($event);
			
			$activities = $activityData->GetAllActivities($activityPage);
			
			$activityResponseArray = array();
			
			foreach($activities as $activity) {
				$noBooked = $activityData->GetActivityNumber($activity);				
				$capacity = $activity->getActivityCapacity();
				$placesLeft = $capacity > 0 ? $capacity - $noBooked : "Unlimited";				
				
				$temp = array();
				$temp["activityId"] = $activity->getId();
				$temp["activityName"] = $activity->getActivityName();
				$temp["placesRemaining"] = $placesLeft;
				
				$activityResponseArray[] = $temp;
			}
		
			$post_data = json_encode($activityResponseArray);
		} catch(Exception $e) {
			$post_data = "Error: " . $e;
		}
		
		echo $post_data;
	}
	
	public function UpdateBooking($bookingId, $activityId, $fee, $paid) {		
		//The parameters will not be null if they have been updated
		$bookingData = LogicFactory::CreateObject("Bookings");
		
		$responseArray = array();
		try {
			if($bookingId != null && $bookingData->GetBooking($bookingId)) {
				//Process the booking related changes
				$booking = BookingFactory::CreateValueObject();
				$booking->setId($bookingId);
				
				if($fee != null)
					$booking->setBookingFee($fee);

				if($paid != null ) {
					$booking->setPaid($paid);//Ensure we get the boolean value here
				}
							
				//Now we can process activity changes
				$bookingActivity = $bookingData->GetBookingActivityRecord($bookingId);
				
				$tempBookingActivity = null;
				
				if($bookingActivity && $activityId != $bookingActivity->getActivityId()) {	
					//Update the activity
					$tempBookingActivity = BookingActivityFactory::CreateValueObject();
					$tempBookingActivity->setId($bookingActivity->getId());
					$tempBookingActivity->setActivityId($activityId);
				}
				
				if($bookingData->UpdateBooking($booking, $tempBookingActivity, null)) {
					$responseArray["result"] = "success";
					$responseArray["message"] = "";
				}
				
			} else{
				$responseArray["result"] = "failure";
				$responseArray["message"] = "No booking found to update";	
			}				
		} catch(Exception $e) {
				$responseArray["result"] = "failure";
				$responseArray["message"] = $e->getMessage();			
		}
		
		$post_data = json_encode($responseArray);
				
		echo $post_data;
	}
	
	 public function RemoveBooking($bookingID) {
		$responseArray = array();
		$responseArray["result"] = "failure";
		$responseArray["message"] = "";	
	 
        //Authenticate user
        if(Authentication::CheckAuthenticationLevel(ALLTYPES, false) ) {
		
			$bookingData = LogicFactory::CreateObject("Bookings");
			$accountData = LogicFactory::CreateObject("Accounts");
			
			try {
				//Get booking
				$booking = $bookingData->GetBooking($bookingID);
				//Get user account
				$userAccount = $accountData->GetAccount(Authentication::GetLoggedInId());	
				//Get account
				$bookingAccount = $bookingData->GetBookingAccount($booking);
				//If event/SSAGO exec or own booking, no further check need to be done
				if($userAccount->getId() == $bookingAccount->getId() || Authentication::CheckAuthenticationLevel(EVENTEXEC|SSAGOEXEC)) {
					//Remove booking
					$bookingData->RemoveBooking($booking);
					$responseArray["result"] = "success"; 
				} else if(Authentication::CheckAuthenticationLevel(CLUBREP, false)){ //If club rep, ensure they are only removing a club member booking
					
					//Compare clubs
					$userClub = $accountData->GetMemberClub($userAccount);
					$bookingClub = $accountData->GetMemberClub($bookingAccount);
					
					if($userClub->getId() != $bookingClub->getId()) {
						$this->errorMessage = "You may only remove bookings for members of " . $bookingClub->getName();
						
						$responseArray["result"] = "failure";
						$responseArray["message"] = "You may only remove bookings for members of " . $bookingClub->getName();
					} else {
						//Remove booking
						$bookingData->RemoveBooking($booking);
						$responseArray["result"] = "success";
					}
				} else {
					$responseArray["result"] = "failure";
					$responseArray["message"] = "An error occured authenticating account, please log in and try again";
				}		
			} catch (Exception $e) {
				$responseArray["result"] = "failure";
				$responseArray["message"] = $e->getMessage();
			}      
       } else {
			$responseArray["result"] = "failure";
			$responseArray["message"] = "An error occured authenticating account, please log in and try again";	
		}   
			
        $post_data = json_encode($responseArray);
				
		echo $post_data;
    }
	
	private function CreateSummary($bookingData, AccountVO $account, BookingVO $booking) {
		$bookingData = LogicFactory::CreateObject("Bookings");
	
        //Get user's booking summary
        $activity = $bookingData->GetBookingActivity($booking);

        $summary = array();
        
        $summary['userID'] = htmlspecialchars($account->getId());
        $summary['userName'] = htmlspecialchars($account->getName());
        $summary['bookingId'] = htmlspecialchars($booking->getId());
        $summary['fee'] = htmlspecialchars($booking->getBookingFee());
		$summary['paid'] = htmlspecialchars($booking->getPaid());
        $summary['activityID'] = htmlspecialchars($activity->getId());
        $summary['activityName'] = htmlspecialchars($activity->getActivityName());
        
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
