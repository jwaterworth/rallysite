<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of BookingFormPageController
 *
 * @author James
 */
class BookingFormPageController extends PageController {
    
    private $event;
    
    private $ownBooking;
    
    function __construct($eventID, $ownBooking = true) {
        $this->data = array();
        $this->ownBooking = $ownBooking;
        
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
        
        
        /*$accountData = LogicFactory::CreateObject("Accounts");
        $accountData = new Accounts();
        
        //Check for booking
        if($ownBooking && $this->CheckAuth(ALLTYPES, false)) {
            $account = $accountData->GetAccount($this->auth->getAuthData('id'));
        }
        
        $bookingData = LogicFactory::CreateObject("Bookings");
        $bookingData = new Bookings();
        
        $booking = $bookingData->GetAccountBooking($event, $account);
        
        //Get activity
        
        //Get food choices*/
    }
    
    public function GeneratePageData() {
	
        //Create logic objects
        $accountData = LogicFactory::CreateObject("Accounts");
        $activityData = LogicFactory::CreateObject("Activities");
        $bookingData = LogicFactory::CreateObject("Bookings");
        
        //Set auth type depending on whether own booking or on behalf of club member
        $authType = $this->ownBooking ? ALLTYPES : CLUBREP;
        
        if(!$this->CheckAuth($authType, false)) {
            $this->errorMessage = "An error occurred authenticating account, please log in and try again";
            return;
        }
		        
        //If booking on behalf of club member
        if(!$this->ownBooking) {
            $this->data['bookingType'] = 'clubBooking';
            try {
                $clubRepAccount = $accountData->GetAccount(Authentication::GetLoggedInId());
                $club = $accountData->GetMemberClub($clubRepAccount);
                $clubMembers = $accountData->GetClubAccounts($club);
				
				//Get the club bookings to ensure we only list members who do not currently have a booking for this event
				$clubBookings = $bookingData->GetClubBookings($this->event, $club);
				
				//Array to hold accounts who already have bookings for this event
				$bookedAccounts = array();
				
				//Scan club bookings to pick up the account Ids
				foreach($clubBookings as $clubBooking) {
					$bookedAccounts[] = $clubBooking->getUserID();
				}			
				
                $arrClubMembers = array();

                foreach($clubMembers as $accountVO) {	
					//only get accounts who don't already have bookings
					if(!in_array($accountVO->getID(), $bookedAccounts)) {
						$account = array();
						
						$account['id'] = htmlspecialchars($accountVO->getId());
						$account['name'] = htmlspecialchars($accountVO->getName());
						$account['email'] = htmlspecialchars($accountVO->getEmail());
						$account['phone'] = htmlspecialchars($accountVO->getPhoneNumber());

						$arrClubMembers[] = $account;
					}                    
                }
                $this->data['clubMembers'] = $arrClubMembers;
            } catch (Exception $e) {
                $this->errorMessage = $e->getMessage();
            }
            
        } else { //else set own user details
            $this->data['bookingType'] = 'ownBooking';
            
            try {
                $account = $accountData->GetAccount(Authentication::GetLoggedInId());
                $club = $accountData->GetMemberClub($account);

                $this->data['userID'] = htmlspecialchars($account->getId());
                $this->data['userName'] = htmlspecialchars($account->getName());
                $this->data['userEmail'] = htmlspecialchars($account->getEmail());
                $this->data['userPhone'] = htmlspecialchars($account->getPhoneNumber());
                $this->data['userAddress'] = htmlspecialchars($account->getAddress());
                $this->data['emergName'] = htmlspecialchars($account->getEmergName());
                $this->data['emergPhone'] = htmlspecialchars($account->getEmergPhone());
                $this->data['emergAddress'] = htmlspecialchars($account->getEmergAddress());
                $this->data['dietaryReq'] = htmlspecialchars($account->getDietaryReq());
                $this->data['medicalCond'] = htmlspecialchars($account->getMedicalConditions());
                $this->data['club'] = htmlspecialchars($club->getName());

            } catch (Exception $e) {
                $this->errorMessage = $e->getMessage();
                return;
            }        
        }
        //Get list of activities
        $this->data['activities'] = $this->GetActivities($activityData);
        
        //Get food choices
        $this->data['foodTypes'] = $this->GetFoodChoices($bookingData);
    }
        
    public function SaveBooking($userID, $activityID, $foodChoices) {
        //Authenticate user
        if(!$this->CheckAuth(ALLTYPES) ) {
             return $this->errorMessage = "An error occured authenticating account, please log in and try again";
           
        }
        $bookingData = LogicFactory::CreateObject("Bookings");	
		$accountData = LogicFactory::CreateObject("Accounts");
		
		$bookingAccount = $accountData->GetAccount($userID);
		
		$currLoggedInId = Authentication::GetLoggedInId();
		//Ensure that if the user is not the same as the logged in user, they have the appropriate permissions
		if($userID != $currLoggedInId) {
			//If not event or ssago exec
			if(!$this->CheckAuth(EVENTEXEC|SSAGOEXEC, false)){
				//They'll need to be a club rep with the same club
				if($this->CheckAuth(CLUBREP, false)) {
					$loggedinAccount = $accountData->GetAccount($currLoggedInId);			
					if($bookingAccount->getClubId() != $loggedinAccount->getClubId()) {
						$this->errorMessage = "You can only create bookings for members of your own club.";
						return false;
					}
				}	
				else {
					$this->errorMessage = "You must be a club representative to create somebody else's booking.";
					return false;
				}				
			}
		}			
		
		//Ensure this user doesn't already have a booking for this event
		try {
			//This is a really nasty approach but there would  be a lot to change otherwise
			//This method will throw an exception if a booking doesn't exist
			$bookingData->GetAccountBooking($this->event, $bookingAccount);
			$this->errorMessage = "A booking for this account on this event already exists.";
			return false;
		}
		catch(Exception $e) {
			//Swallow the exception as this is good for once
		}		
        
        $booking = BookingFactory::CreateValueObject();
        $booking->setUserID(htmlspecialchars($userID));
        
        try {
             //Calculate fee
            $fee = $bookingData->CalculateFee($this->event, htmlspecialchars($activityID));
            $booking->setBookingFee($fee);

            //Save booking with activity ID and food choice ID
            $cleanFoodChoices = array();
            
            foreach($foodChoices as $foodChoiceID) { //Sanitise each element
                $cleanFoodChoices[] = $foodChoiceID;
            }
            
            $bookingID = $bookingData->SaveBooking($booking, $activityID, 1, $cleanFoodChoices);
            
            $booking = $bookingData->GetBooking($bookingID);
            
            $emailer = new Email();
            $emailer->SendBookingEmail($this->event, $booking);
            
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
       
        return true;
    }
    
    public function RemoveBooking($bookingID) {
        //Authenticate user
        if(!$this->CheckAuth(ALLTYPES, false) ) {
             return $this->errorMessage = "An error occured authenticating account, please log in and try again";
        }
        
        
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
            if($userAccount->getId() == $bookingAccount->getId() || $this->CheckAuth(EVENTEXEC|SSAGOEXEC)) {
                //Remove booking
                $bookingData->RemoveBooking($booking);
            } else if($this->CheckAuth(CLUBREP, false)){ //If club rep, ensure they are only removing a club member booking
                
                //Compare clubs
                $userClub = $accountData->GetMemberClub($userAccount);
                $bookingClub = $accountData->GetMemberClub($bookingAccount);
                
                if($userClub->getId() != $bookingClub->getId()) {
                    $this->errorMessage = "You may only remove bookings for members of " . $bookingClub->getName();
                    return;
                } else {
                    //Remove booking
                    $bookingData->RemoveBooking($booking);
                }
            }         
        } catch (Exception $e) {
            return $this->errorMessage = $e->getMessage();
        }
        
        return;
    }
    
    private function GetActivities($activityData) {
        //Get list of activities
        try {
            //Get page and activity data
			
            $activityPage = $activityData->GetActivitiesPage($this->event);
            $activityVOs = $activityData->GetAllActivities($activityPage);
            
            //Sort activities
            usort($activityVOs, 'cmp');
           
            //Create array to hold activities
            $arrActivities = array();
        
            //Add each activity to activities array
            foreach($activityVOs as $activityVO) {
                $activity = array();

                $activity['id'] = $activityVO->getId();
                $activity['name'] = $activityVO->getActivityName();
                $activity['description'] = $activityVO->getActivityDescription();
                $activity['capacity'] = $activityVO->getActivityCapacity();
                $activity['cost'] = $activityVO->getActivityCost();
                $activity['imageLoc'] = $activityVO->getActivityImageLoc();
                $activity['enabled'] = $activityData->CheckSpace($activityVO);
                $arrActivities[] = $activity;
            }
                
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return;
        }
        
        return $arrActivities;
    }
    
    private function GetFoodChoices($bookingData) {
        try {
            $bookingInfo = $bookingData->GetBookingInfo($this->event);
            $foodTypes = $bookingData->GetFoodTypes($bookingInfo);
            
            //Get Food Types
            $arrFoodTypes = array();
            foreach($foodTypes as $foodTypeVO) {
                $foodType = array();
                $foodType['errorMessage'] = null;
                $foodType['id'] = $foodTypeVO->getId();
                $foodType['name'] = $foodTypeVO->getFoodTypeName();
                
                //Get all food choices for each food type
                $foodChoices = $bookingData->GetFoodChoices($foodTypeVO);
                
                if(sizeof($foodChoices) < 1 ) {
                    $foodType['errorMessage'] = "No Choices Found";
                    continue;
                }
                
                $arrFoodChoices = array();
                
                foreach($foodChoices as $foodChoiceVO) {
                    $foodChoice = array();
                    $foodChoice['id'] = $foodChoiceVO->getId();
                    $foodChoice['name'] = $foodChoiceVO->getName();
                    $foodChoice['notes'] = $foodChoiceVO->getNotes();

                    $arrFoodChoices[] = $foodChoice;
                }
                
                $foodType['foodChoices'] = $arrFoodChoices;
                $arrFoodTypes[] = $foodType;
           }           
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return Array();
        }
		
        return $arrFoodTypes;
    }  

}

function cmp(ActivityVO $a, ActivityVO $b) {
        return ($a->getId() < $b->getId()) ? -1 : 1;
    }

?>
