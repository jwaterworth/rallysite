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
			
			$post_data = json_encode($clubResponseArray, JSON_FORCE_OBJECT);
		} catch(Exception $e) {
			$post_data = "Error: " . $e;
		}
		
		echo $post_data;
	}
	
	public function GetClubBookings($eventId, $clubId) {
		$accountData = LogicFactory::CreateObject("Accounts");
		
		$postData = "";
		
		try {
			$club = ClubFactory::CreateValueObject();
			$club->setId($clubId);
			$clubAccounts = $accountData->GetClubAccounts($club);
			
			$clubBookings = $accountData->GetClubBookings($eventId, $club);
			
			 //Create a summary for each booking
            foreach($bookings as $booking) {
                //Get account for booking
                $account = $bookingData->GetBookingAccount($booking);
                $clubBookings[] = $this->CreateSummary($bookingData, $account, $booking);   
            }
            
			
			$clubAccountsResponse = array();
			
			foreach($clubAccounts as $account) {
				$temp = array();
				$temp["id"] = $account->getId();
				$temp["name"] = $account->getName();
				
				$clubAccountsResponse[] = $temp;
			}
			
			$post_data = json_encode($clubAccountsResponse, JSON_FORCE_OBJECT);
		} catch(Exception $e) {
			$post_data = "Error: " . $e;
		}
		
		echo $post_data;
	}
}

?>
