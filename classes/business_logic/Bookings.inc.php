<?php
require_once(BUSLOGIC_PATH."/BusinessLogic.inc.php");

/**
 * Description of Bookings
 *
 * @author James
 */
class Bookings extends BusinessLogic {
    
    public function GetBookingInfo(EventVO $event) {
        $this->CheckParam($event, "GetBookingInfo");
        
        $dbBookingInfo = BookingInfoFactory::GetDataAccessObject();
        
        $bookingInfo = $dbBookingInfo->GetById($event->getId());
        
        if($bookingInfo == null) {
            throw new Exception("No booking information found");
        }
        
        return $bookingInfo;
    }
    
    public function GetFees(BookingInfoVO $bookingInfo) {
        $this->CheckParam($bookingInfo, "GetFees");
        
        $dbFees = FeesFactory::GetDataAccessObject();
        
        $fees = $dbFees->GetByForeignKey($bookingInfo->getId(), false);
        
        if($fees == null){
            throw new Exception("No fees found for this event");
        }
        
        return $fees;
    }
    
    public function GetFoodTypes(BookingInfoVO $bookingInfo) {
        $this->CheckParam($bookingInfo, "GetFoodTypes");
        
        $dbFoodTypes = FoodTypeFactory::GetDataAccessObject();
        
        $foodTypes = $dbFoodTypes->GetByForeignKey($bookingInfo->getId());
        
        if(sizeof($foodTypes) < 1) {
            throw new Exception("No food types found for this event");
        }
        
        return $foodTypes;
    }
    
    public function GetFoodChoices(FoodTypeVO $foodType) {
        $this->CheckParam($foodType, "GetFoodChoices");
        
        $dbFoodChoices = FoodChoiceFactory::GetDataAccessObject();
        $foodChoices = $dbFoodChoices->GetByForeignKey($foodType->getId());
        
        //It is possible for food types to have no food choices assigned
        /*if($foodChoices == null) {
            throw new Exception("No food choices found for this food type");
        }*/
        
        return $foodChoices;
    }
    
    public function GetBooking($id) {
        $this->CheckParam($id, "GetBooking");
        
        $dbBookings = BookingFactory::GetDataAccessObject();
        $booking = BookingFactory::CreateValueObject();
        
        $booking = $dbBookings->GetById($id);
        
        if($booking == null) {
            throw new Exception("Booking does not exist");
        }
        
        return $booking;
    }
    
    public function GetBookingAccount(BookingVO $booking) {
        $this->CheckParam($booking, "GetBookingAccount");
        
        $accountData = LogicFactory::CreateObject("Accounts");
        
        $account = $accountData->GetAccount($booking->getUserID());
        
        if($account == null) {
            throw new Exception("Account not found for booking");
        }
        
        return $account;
    }
    
    public function GetAccountBooking(EventVO $event, AccountVO $account) {
        $this->CheckParam($account, "GetAccountBooking");
        
        //Business Logic Objects
        $activityData = LogicFactory::CreateObject("Activities");
        
        //Data Access Objects
        $dbBookings = BookingFactory::GetDataAccessObject();
        
        //Get all bookings for account
        $userBookings = $dbBookings->GetByAttribute(BookingVO::$dbUserID, $account->getId());
        
        if($userBookings == null) { //We know for certain no event bookings for account
            throw new Exception("No bookings found for this account");
        }
        
        //Get all activities for event
        $activities = $activityData->GetAllActivities($activityData->GetActivitiesPage($event));
        
        if(sizeof($activities) > 0) {
            //Check for bookings associated with event
            foreach($userBookings as $booking) {
                $bookingActivity = $this->GetBookingActivity($booking);
                //Check booking activity against all activities for event
                foreach($activities as $activity) {
                    if($bookingActivity->getId() == $activity->getId()){
                        return $booking;
                    }
                }
            }
        }
        //If no activities match the booking activity we know there are no bookings
        throw new Exception("No " . $event->getName() . " bookings found for this account");  
    }
    
	public function GetBookingActivityRecord($bookingId) {
		//Data access objects
        $dbBookingActivities = BookingActivityFactory::GetDataAccessObject();
        $dbActivities = ActivityFactory::GetDataAccessObject();
        
        $bookingActivities = $dbBookingActivities->GetByAttribute(
                BookingActivityVO::$dbBookingID, $bookingId);
        
        //As there may be multiple booking activities per booking, each with 
        //different priorities. For now we will pick priority 1 only NEEDS ATTENTION
        foreach($bookingActivities as $bookingActivityVO) {
            if($bookingActivityVO->getPriority() == 1){
                $bookingActivity = $bookingActivityVO;
                break;
            }
        }
		
		return $bookingActivity;
	}
	
	
    public function GetBookingActivity(BookingVO $booking) {
        $activity = null;
        $bookingActivity = null;
        
        $this->CheckParam($booking, "GetBookingActivity");
        
        //Data access objects
        $dbBookingActivities = BookingActivityFactory::GetDataAccessObject();
        $dbActivities = ActivityFactory::GetDataAccessObject();
        
        $bookingActivities = $dbBookingActivities->GetByAttribute(
                BookingActivityVO::$dbBookingID, $booking->getId());
        
        //As there may be multiple booking activities per booking, each with 
        //different priorities. For now we will pick priority 1 only NEEDS ATTENTION
        foreach($bookingActivities as $bookingActivityVO) {
            if($bookingActivityVO->getPriority() == 1){
                $bookingActivity = $bookingActivityVO;
                break;
            }
        }
        
        //Get activity object using activity ID
        if($bookingActivity != null){
            $activity = $dbActivities->GetById($bookingActivity->getActivityID());
        }
        
        if($activity == null) {
            throw new Exception("Activity not found for booking");
        }
        
        return $activity;
    }
    
    public function GetAllBookings(EventVO $event) {
        $this->CheckParam($event, "GetAllBookings");
        
        $bookings = array();
        $activityLogic = LogicFactory::CreateObject("Activities");
        
        $dbActivityPage = ActivityPageFactory::GetDataAccessObject();
        $dbActivity = ActivityFactory::GetDataAccessObject();
        $dbBookingActivities = BookingActivityFactory::GetDataAccessObject();
        
        $activityPage = ActivityPageFactory::CreateValueObject();
        $activities = ActivityFactory::CreateValueObject();
        $bookingActivities = BookingActivityFactory::CreateValueObject();
        
        //Get activity page for event
        $activityPage = $dbActivityPage->GetById($event->getActivityPageID());
        //Get all activities associated with activity page
        $activities = $dbActivity->GetByForeignKey($activityPage->getId());
        
        //Get all BookingActivity records belonging to each activity
        foreach($activities as $activity) {
            $bookingActivities = $dbBookingActivities->GetByAttribute(
                    BookingActivityVO::$dbActivityID, $activity->getId());
            //Get all bookings associated with BookingActivity
            $bookings[] = $activityLogic->GetActivityParticipants($activity);
            
            //UNFINSIHED
        }
        
        if(sizeof($bookings) < 1) {
            throw new Exception("No activities found for this event");
        }
        
        return $bookings;
    }
    
    public function GetClubBookings(EventVO $event, ClubVO $club) {
        $this->CheckParam($event, "GetClubBookings - event");
        $this->CheckParam($club, "GetClubBookings - club");
        
        $clubBookings = array();
		
        //Data Access Objects
        $dbBookings = BookingFactory::GetDataAccessObject();
        $dbBookingActivities = BookingActivityFactory::GetDataAccessObject();
        
        //Business Logic Objects
        $accountsLogic = LogicFactory::CreateObject("Accounts");
        $activitiesLogic = LogicFactory::CreateObject("Activities");
        
        //Get club booking IDs
        $clubAccounts = $accountsLogic->GetClubAccounts($club);
        $allClubBookings = array();
        
        //Get all club bookings
        foreach($clubAccounts as $account) {
            $userID = $account->getId();
            $tempArray = $dbBookings->GetByAttribute(BookingVO::$dbUserID, $userID);
            
            foreach($tempArray as $booking) {
                $allClubBookings[] = $booking;
            }
        }
        
        //Get list of event activities
        $activitiesPage = $activitiesLogic->GetActivitiesPage($event);
        $activities = $activitiesLogic->GetAllActivities($activitiesPage);
        $clubBookingActivities = array();
        
        //Get booking activities for each activity
        foreach($activities as $activity) {
            $tempArray = $dbBookingActivities->GetByAttribute(BookingActivityVO::$dbActivityID, $activity->getId());
            
            foreach($tempArray as $bookingActivity) {
                    $clubBookingActivities[] = $bookingActivity;
            }          
        }
        
        //Compare activity id's against booking id's in Booking_Activity table
        foreach($clubBookingActivities as $bookingActivity) {
            foreach($allClubBookings as $booking) {
                //If booking is for an activity on the specified event, add booking to array
                if($bookingActivity->getBookingID() == $booking->getId()) {
                    $clubBookings[] = $booking;
                }
            }
        }
        
        return $clubBookings;
    }
    
    public function CalculateFee(EventVO $event, $activityID) {
        $this->CheckParam($event, "CalculateFees - event");
        $this->CheckParam($activityID, "CalculateFees - activity");
        
        $eventFee = null;
        
        //Get activity cost
        $activityData = LogicFactory::CreateObject("Activities");  
        $activity = $activityData->GetActivity($activityID);
        $activityCost = $activity->getActivityCost();
        
        //Get current fee
        $bookingInfo = $this->GetBookingInfo($event);
        $dbFees = FeesFactory::GetDataAccessObject();      
        $fees = $dbFees->GetByForeignKey($bookingInfo->getId());

		$currFee = null;
		
        foreach($fees as $fee){
			//If curr date is before the deadline
            if($this->CompareDates($this->parseUkDate($fee->getDeadline()), "now"))
			{				
				//Select the fee if no fee is set or if our current fee's deadline is later than this one
				if(!$currFee || $this->CompareDates($this->parseUkDate($currFee->getDeadline()), $this->parseUkDate($fee->getDeadline()))) {				
					$currFee = $fee;
				}
			}
        }
		
		if($currFee) {
			$eventFee = $currFee->getFee();
		} else {
			$eventFee = $fees[count($fees)-1]->getFee(); //Set it to the last fee entered
		}
		        		
        //Calculate total fee
        $totalFee = $activityCost + $eventFee;
        
        if($totalFee == 0) {
            throw new Exception("An error occurred calculating the total fee");
        }
        
        return $totalFee;
    }
	
	private function CompareDates($date1, $date2) {
		$date1Formatted = date("Y-m-d", strtotime($date1));
		$date2Formatted = date("Y-m-d", strtotime($date2));
		return $date1Formatted <= $date2Formatted;
    }
	
	private function parseUkDate($date) {
		$values = explode('/', $date);
		$dateString = sprintf("%s-%s-%s", $values[2], $values[1], $values[0]);
		$newDate = date("Y-m-d", strtotime($dateString));
		return $newDate;
	}
	
    public function MarkBookingPaid(BookingVO $booking) {
        $this->CheckParam($booking, "MarkBookingPaid");
        
        $booking->setPaid(1);
        
        //Do not save using this->SaveBooking as we are not setting food choice/activity
        $dbBooking = BookingFactory::GetDataAccessObject();
        
        if($dbBooking->Save($booking) < 1) {
            throw new Exception("An error occured updating payment status");
        }
        
        return true;
    }
    
    public function SaveBookingInfo(BookingInfoVO $bookingInfo) {
        $this->CheckParam($bookingInfo, "SaveBookingInfo");
        
        $dbBookingInfo = BookingInfoFactory::GetDataAccessObject();
		
        if($dbBookingInfo->Save($bookingInfo) < 1) {
            throw new Exception("An error occurred saving booking information");
        }
        
        return true;
    }
	
	public function UpdateBooking($booking, $bookingActivity, $foodChoices) {
		$dbBookings = BookingFactory::GetDataAccessObject();
        $dbBookingActivities = BookingActivityFactory::GetDataAccessObject();
        $dbBookingFoodChoices = BookingFoodChoiceFactory::GetDataAccessObject();
		
		$activityData = LogicFactory::CreateObject("Activities");
        $activityData = new Activities();         
		
		if($dbBookings->Save($booking) < 1) {
			throw new Exception("An error occurred updating the booking");
		}
		
		if($bookingActivity) {
			 //Check for space on activity
			if($bookingActivity->getActivityId()){
				$activity = $activityData->GetActivity($bookingActivity->getActivityId());
				if(!$activityData->CheckSpace($activity)) {
					throw new Exception("There is no space left on this activity");
				}
			}
			
			if($dbBookingActivities->Save($bookingActivity) < 1) {
				$this->RemoveBooking($booking);
				throw new Exception("An error occurred saving booking activity");
			}	
		}
		
		//Need to process food choices at some point
        
		return true;
	}
    
    public function SaveBooking(BookingVO $booking, $activityID, $priority, $foodChoices) {
        $this->CheckParam($booking, "SaveBooking - booking");
        $this->CheckParam($activityID, "SaveBooking - activityID");
        
        $dbBookings = BookingFactory::GetDataAccessObject();
        $dbBookingActivities = BookingActivityFactory::GetDataAccessObject();
        $dbBookingFoodChoices = BookingFoodChoiceFactory::GetDataAccessObject();
        
        $activityData = LogicFactory::CreateObject("Activities");
        $activityData = new Activities();
        
        //Check for space on activity
        $activity = $activityData->GetActivity($activityID);
        if(!$activityData->CheckSpace($activity, $priority)) {
            throw new Exception("There is no space left on this activity");
        }
        
        //Check user does not already have a booking for this event
        
        //Set booking to unpaid if nothing is set
		if(!$booking->getPaid())
			$booking->setPaid(0);
         
        $bookingID = $dbBookings->Save($booking);
        
        //Save booking
        if($bookingID < 1) {
            throw new Exception("An error occured saving booking");
        }
        
        $booking = $dbBookings->GetById($bookingID);
        
        //Booking Activity
        $bookingActivity = BookingActivityFactory::CreateValueObject();
        $bookingActivity->setBookingID($booking->getId());
        $bookingActivity->setActivityID($activityID);
		
		if($priority)
			$bookingActivity->setPriority($priority);
        
        if($dbBookingActivities->Save($bookingActivity) < 1) {
            $this->RemoveBooking($booking);
            throw new Exception("An error occured saving booking activity");
        }
        
        //Booking Food Choice
		if($foodChoices) {
			foreach($foodChoices as $foodChoiceID) {
				$bookingFoodChoice = BookingFoodChoiceFactory::CreateValueObject();
				$bookingFoodChoice->setBookingID($booking->getId());
				$bookingFoodChoice->setFoodChoiceID($foodChoiceID);

				if($dbBookingFoodChoices->Save($bookingFoodChoice) < 1) {
					$this->RemoveBooking($booking);
					throw new Exception("An error occured saving booking food choice");
				}
			}
		}
		
        return $bookingID;
    }
    
    public function RemoveBooking(BookingVO $booking) {
        $this->CheckParam($booking, "RemoveBooking");
        
        $errorMessage = null;
        
        $dbBookings = BookingFactory::GetDataAccessObject();
        $dbBookingActivites = BookingActivityFactory::GetDataAccessObject();
        $dbBookingFoodChoices = BookingFoodChoiceFactory::GetDataAccessObject();
        
        //Delete main booking first, as leftover booking activities/food choices will not have such an impact
        if($dbBookings->Delete($booking) < 1) {
            $errorMessage += ": An error occured removing booking ";
        }
        
        //Delete booking activities
        $bookingActivities = $dbBookingActivites->GetByAttribute(BookingActivityVO::$dbBookingID, $booking->getId());
        
        foreach($bookingActivities as $bookingActivity) {
            if($dbBookingActivites->Delete($bookingActivity) < 1) {
                $errorMessage += ": An error occured removing booking activity";
            }
        }
        
        $bookingFoodChoices = $dbBookingFoodChoices->GetByAttribute(BookingFoodChoiceVO::$dbBookingID, $booking->getId());
        
        foreach($bookingFoodChoices as $bookingFoodChoice) {
            if($dbBookingFoodChoices->Delete($bookingFoodChoice) < 1) {
                $errorMessage += ": An error occured removing booking food choice";
            }
        }
        
        if($errorMessage != null) {
            throw new Exception($errorMessage);
        }
        
        return true;
    }
}

?>
