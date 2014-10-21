<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of BookingSummaryPageController
 *
 * @author James
 */
class BookingSummaryPageController extends PageController{
    
    private $event;
    
    private $ownBooking;
    
    private $bookingID;
    
    
    function __construct($eventID, $bookingID = null) {
        $this->data = array();
        if($bookingID == null) {
            $this->ownBooking = true;
            $this->bookingID = null;
        } else {
            $this->ownBooking = false;
            $this->bookingID = $bookingID;
        }
        
        $eventData = LogicFactory::CreateObject("Event");
        
        try {
            $event = $eventData->GetEvent($eventID);
            $this->event = $event;
        } catch(Exception $e) {
            $this->errorMessage = $e->getMessage();
            return;
        }
    }
    
    public function GeneratePageData() {
        //Create logic objects
        $accountData = LogicFactory::CreateObject("Accounts");
        $bookingData = LogicFactory::CreateObject("Bookings");
        $bookingData = new Bookings();
        //Set auth type depending on whether own booking or on behalf of club member
        $authType = $this->ownBooking ? ALLTYPES : CLUBREP;
        
        if(!$this->CheckAuth($authType, false)) {
            $this->errorMessage = "An error occured authenticating account, please log in and try again";
            return;
        }
        
        //If club member booking
        if(!$this->ownBooking) {
            $this->data['clubBooking'] = true;
            try {
                //Get booking
                $booking = $bookingData->GetBooking($this->bookingID);
                //Get user account (club rep)
                $userAccount = $accountData->GetAccount(Authentication::GetLoggedInId());
                //Get booking account
                $bookingAccount = $bookingData->GetBookingAccount($booking);
                
                //Check clubs of club rep and bookingaccount match
                if($userAccount->getClubID() != $bookingAccount->getClubID()) {
                    $this->errorMessage = "You may only view bookings for members of your own club";
                    return;
                } else { //Get booking details 
                    $this->data['booking'] = $this->GetBookingDetails($booking, $bookingAccount, $bookingData);
                }
                
            } catch(Exception $e) {
                $this->errorMessage = $e->getMessage();
            }
            
        } else {
            $this->data['clubBooking'] = false;
            try {
                //Get user account (club rep)
                $userAccount = $accountData->GetAccount(Authentication::GetLoggedInId());
                
                $booking = $bookingData->GetAccountBooking($this->event, $userAccount);

                $this->data['booking'] = $this->GetBookingDetails($booking, $userAccount, $bookingData);
                
            } catch(Exception $e) {
                $this->errorMessage = $e->getMessage();
            }
                        
        }
    }
    
    private function GetBookingDetails(BookingVO $bookingVO, AccountVO $account, Bookings $bookingData) {
        $booking = array();

        //Get activity
        $activity = $bookingData->GetBookingActivity($bookingVO);
        
        //Account details
        $booking['userID'] = htmlspecialchars($account->getId());
        $booking['userName'] = htmlspecialchars($account->getName());
        $booking['email'] = htmlspecialchars($account->getEmail());
        $booking['phone'] = htmlspecialchars($account->getPhoneNumber());
        $booking['dob'] = htmlspecialchars($account->getDateOfBirth());
        $booking['address'] = htmlspecialchars($account->getAddress());
        $booking['medicalCond'] = htmlspecialchars($account->getMedicalConditions());
        $booking['dietaryReq'] = htmlspecialchars($account->getDietaryReq());
        $booking['emergName'] = htmlspecialchars($account->getEmergName());
        $booking['emergPhone'] = htmlspecialchars($account->getEmergPhone());
        $booking['emergAddress'] = htmlspecialchars($account->getEmergAddress());   

        //Booking details
        $booking['bookingID'] = $bookingVO->getId();
        $booking['bookingFee'] = '£' . $bookingVO->getBookingFee();
        
        $baseFee = $bookingVO->getBookingFee() - $activity->getActivityCost();
        
        $booking['baseFee'] = '£' . $baseFee;

        //Activity Details
        $booking['activityID'] = $activity->getId();
        $booking['activityName'] = $activity->getActivityName();
        $booking['activityCost'] = '£' . $activity->getActivityCost();

        // Food choices
        /*$bookingInfo = $bookingData->GetBookingInfo($this->event);
        $foodTypes = $bookingData->GetFoodTypes($bookingInfo);
        
        foreach($foodTypes as $foodType) {
        }*/
        
        return $booking;
    }

}

?>
