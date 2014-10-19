<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of PaymentPageController
 *
 * @author James
 */
class PaymentPageController extends PageController{
    
    private $event;
    
    private $ownBooking;
    
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
            $this->data['eventName'] = $this->event->getName();
            $this->data['eventID'] = $this->event->getId();
        } catch(Exception $e) {
            $this->errorMessage = $e->getMessage();
            return;
        }
    }
    
    public function GetPageData() {
        //Create logic objects
        $accountData = LogicFactory::CreateObject("Accounts");
        $bookingData = LogicFactory::CreateObject("Bookings");
        $bookingData = new Bookings();
        //Set auth type depending on whether own booking or on behalf of club member
        $authType = $this->ownBooking ? ALLTYPES : CLUBREP;
        
        if(!$this->CheckAuth($authType, false)) {
            $this->errorMessage = "An error occurred authenticating account, please log in and try again";
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
        
        //Payment details
        try {
            $bookingInfo = BookingInfoFactory::CreateValueObject();
            $bookingInfo = $bookingData->GetBookingInfo($this->event);

            $this->data['paymentAddress'] = $bookingInfo->getPaymentAddress();
            $this->data['paymentName'] = "SSAGO Autumn Rally";
            $this->data['paymentMemberID'] = $bookingInfo->getPaymentMemberID();
            
            
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
        
        
    }
    
    private function GetBookingDetails(BookingVO $bookingVO, AccountVO $account, Bookings $bookingData) {
        $booking = array();

        //Get activity
        $activity = $bookingData->GetBookingActivity($bookingVO);
        
        if($bookingVO->getPaid()) {
            $booking['paid']  = true;
        } else {
            $booking['paid'] = false;
        }
        
        //Account details
        $booking['userID'] = $account->getId();
        $booking['userName'] = $account->getName();
        $booking['email'] = $account->getEmail();
        $booking['phone'] = $account->getPhoneNumber();
        $booking['dob'] = $account->getDateOfBirth();
        $booking['address'] = $account->getAddress();
        $booking['medicalCond'] = $account->getMedicalConditions();
        $booking['dietaryReq'] = $account->getDietaryReq();
        $booking['emergName'] = $account->getEmergName();
        $booking['emergPhone'] = $account->getEmergPhone();
        $booking['emergAddress'] = $account->getEmergAddress();   

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
    
    public function SendPaymentDetailsEmail($accountID) {
        
        if(!$this->CheckAuth(ALL_TYPES, false)) {
            $this->errorMessage = "An error occured authenticating account, please log in and try again";
            return;
        }
        
        $emailer = new Email();
        $emailer->SendPaymentDetails($this->event, $accountID);
    }

}

?>
