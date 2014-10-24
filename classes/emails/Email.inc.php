<?php
require_once(CLASS_PATH.'/emails/class/phpmailer.inc.php');
/**
 * Description of Email
 *
 * @author Bernard
 */
class Email {
    
	public $errorMessage;
	
    function __construct() {
        $errorMessage = null;
    }
    
    public function SendRegistrationEmail($email) {
        $accountData = LogicFactory::CreateObject("Accounts");
        $accountData = new Accounts();
        $account = null;
        
        //Email member
        try {
            $account = $accountData->GetAccountByUsername($email);
            
            //True parameter allows exceptions to be thrown
            $phpmailer = new PHPMailer(true);
            $phpmailer->AddReplyTo('loughboroughrallycommittee@gmail.com', 'Puzzle Rally Event Exec');
        
            $phpmailer->AltBody = 'To view the message, please use an HTML compatible email client';
            $phpmailer->SetFrom('ssagoevents@saggo.org.uk', 'SSAGO Registration');
        
            $address = $account->getEmail();
            $phpmailer->AddAddress($address);
            
            $phpmailer->Subject = 'SSAGO Events Account Registration';
            
            $phpmailer->MsgHTML($this->GenerateRegistrationEmail($account));

            $phpmailer->Send();
        } catch(phpmailerException $e) {
            $this->errorMessage = $e->errorMessage();
			return false;
        } catch(Exception $e) {
            $this->errorMessage = $e->getMessage();
			return false;
        }
        
        //Email Club Representatives
        try {
            $club = $accountData->GetMemberClub($account);
            $clubReps = $accountData->GetClubReps($club);
            
            $phpmailer = new PHPMailer(true);
            $phpmailer->AddReplyTo('loughboroughrallycommittee@gmail.com', 'Puzzle Rally Event Exec');
            
            $phpmailer->AltBody = 'To view the message, please use an HTML compatible email client';
            $phpmailer->SetFrom('ssagoevents@ssago.com', 'SSAGO Registration');
            
            foreach($clubReps as $clubRep) {
                $phpmailer->AddAddress($clubRep->getEmail());
            }
            
            $phpmailer->Subject = 'Club Member Registration';
            $phpmailer->MsgHTML($this->GenerateApprovalRequestEmail($account, $club));
            
            $phpmailer->Send();
        } catch(phpmailerException $e) {
            $this->errorMessage = $e->errorMessage();
			return false;
        } catch(Exception $e) {
            $this->errorMessage = $e->getMessage();
			return false;
        }
        
        return true;
    }
    
    public function SendAccountApprovalEmail($account) {
        //Email member
        try {
            //True parameter allows exceptions to be thrown
            $phpmailer = new PHPMailer(true);
            $phpmailer->AddReplyTo('donotreply@ssago.org.uk', 'SSAGO  Executive');
        
            $phpmailer->AltBody = 'To view the message, please use an HTML compatible email client';
            $phpmailer->SetFrom('ssagoevents@ssago.org.uk', 'SSAGO Registration');
        
            $address = $account->getEmail();
            $phpmailer->AddAddress($address);
            
            $phpmailer->Subject = 'SSAGO Events Account Registration';
            
            $phpmailer->MsgHTML($this->GenerateApprovalEmail($account));
            
            $phpmailer->Send();
        } catch(phpmailerException $e) {
            echo $e->errorMessage();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        
        return;
    }
    
    public function SendBookingEmail(EventVO $event, BookingVO $booking) {
        $bookingData = LogicFactory::CreateObject("Bookings");
        $bookingData = new Bookings();
        
        //Get Account
        $account = AccountFactory::CreateValueObject();
        $account = $bookingData->GetBookingAccount($booking);
        
        //Email member
        try {
            //True parameter allows exceptions to be thrown
            $phpmailer = new PHPMailer(true);
            $phpmailer->AddReplyTo('loughboroughrallycommittee@gmail.com', 'Puzzle Rally Event Exec');
        
            $phpmailer->AltBody = 'To view the message, please use an HTML compatible email client';
            $phpmailer->SetFrom('ssagoevents@saggo.org.uk', 'SSAGO Bookings');
        
            $address = $account->getEmail();
            $phpmailer->AddAddress($address);
            
            $phpmailer->Subject = $event->getName() . ' Booking';
            
            $phpmailer->MsgHTML($this->GenerateBookingConfirmation($bookingData, $event, $account, $booking));
            
            $phpmailer->Send();
        } catch(phpmailerException $e) {
            echo $e->errorMessage();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        
        return;
    }
    
    public function SendPaymentDetails(EventVO $event, $accountID) {
        $bookingData = LogicFactory::CreateObject("Bookings");
        
        $accountData = LogicFactory::CreateObject("Accounts");
        
        //Email member
        try {
            $account = $accountData->GetAccount($accountID);
            $replyToAddress = $account->getEmail();

            $bookingInfo = $bookingData->GetBookingInfo($event);

            //$eventExecID = $bookingInfo->getPaymentMemberID();
           // $eventExecAccount = $accountData->getAccount($eventExecID);
            
            //$address = $eventExecAccount->getEmail();
			$address = "ssagopuzzlerally@gmail.com";
            
            //True parameter allows exceptions to be thrown
            $phpmailer = new PHPMailer(true);
            $phpmailer->AddReplyTo($replyToAddress, $account->getName());
        
            $phpmailer->AltBody = 'To view the message, please use an HTML compatible email client';
            $phpmailer->SetFrom($replyToAddress, 'SSAGO Event Payment');
        
            $phpmailer->AddAddress($address);
            
            $phpmailer->Subject = $event->getName() . ' - Bank Transfer Details Requested';
            
            $phpmailer->MsgHTML($this->GeneratePaymentDetails($event, $account));
            
            $phpmailer->Send();
        } catch(phpmailerException $e) {
            echo $e->errorMessage();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        
    }
    
    public function TestAttachment(){
        try {
            //True parameter allows exceptions to be thrown
            $phpmailer = new PHPMailer(true);
            $phpmailer->AddReplyTo('donotreply@ssago.org.uk', 'SSAGO  Executive');
        
            $phpmailer->AltBody = 'To view the message, please use an HTML compatible email client';
            $phpmailer->SetFrom('ssagoevents@saggo.org.uk', 'SSAGO Bookings');
        
            
            $phpmailer->AddAddress('j.waterworth1990@gmail.com');
            
            $phpmailer->AddAttachment('/diskh/zco/cojw3/ssago_images/test.csv');
            
            $phpmailer->Subject = 'attachment test';
            
            $phpmailer->MsgHTML('please work!');
            
            $phpmailer->Send();
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
        }

    }
	
	public function SendProblemEmail($title, $details, $name, $club, $email) {
		try {
			//True parameter allows exceptions to be thrown
            $phpmailer = new PHPMailer(true);
			
			$phpmailer->AddReplyTo($email, 'Issue Reporter');
			
			$phpmailer->AltBody = 'To view the message, please use an HTML compatible email client';
            $phpmailer->SetFrom('rallysite@saggo.org.uk', 'Rally site');
			
			$phpmailer->AddAddress('rallysupport@ssago.org.uk');
			
			$phpmailer->Subject = 'Rally Site: Problem Reported';
			
			return $this->GenerateProblemEmail($title, $details, $name, $club, $email);
			
			$phpmailer->MsgHTML($this->GenerateProblemEmail($title, $details, $name, $club, $email));
			
			$phpmail->Send();
		} catch(phpmailException $e) {
			return false;
		}
		
		return true;
	}
    
    private function GenerateProblemEmail($title, $details, $name, $club, $email) {
		$email_template = file_get_contents(TEMPLATE_PATH."/emails/problem.html");
		
		 //Insert name and email into placeholders
        $email = sprintf($email_template, $title, $details, $name, $club, $email, $email);
        
        return $email;
	}
        
    private function GenerateRegistrationEmail(AccountVO $account){
        $email_template = file_get_contents(TEMPLATE_PATH."/emails/registration.html");
        
        //Insert name and email into placeholders
        $email = sprintf($email_template, $account->getName(), $account->getEmail());
        
        return $email;
    }
    
    private function GenerateApprovalRequestEmail(AccountVO $account, ClubVO $club) {
        $email_template = file_get_contents(TEMPLATE_PATH."/emails/approval_request.html");
        
        $email = sprintf($email_template, $account->getName(), $club->getName());
        
        return $email;
    }
    
    private function GenerateApprovalEmail(AccountVO $account) {
        $email_template = file_get_contents(TEMPLATE_PATH."/emails/member_approval.html");
        $email = sprintf($email_template, $account->getName(), $account->getEmail());
        
        return $email;
    }
    
    private function GenerateBookingConfirmation($bookingData, EventVO $event, AccountVO $account, BookingVO $booking) {
        //Get Activity
        $activity = ActivityFactory::CreateValueObject();
        $activity = $bookingData->GetBookingActivity($booking);
        
        $email_template = file_get_contents(TEMPLATE_PATH."/emails/booking_confirmation.html");
        
        $email = sprintf($email_template, $account->getName(), $event->getName(), $activity->getActivityName(), $booking->getBookingFee());
        
        return $email;
    }
   
    private function GeneratePaymentDetails(EventVO $event, AccountVO $memberAccount) {
                
        $email_template = file_get_contents(TEMPLATE_PATH."/emails/bank_details.html");
        
        $email = sprintf($email_template, $memberAccount->getName(), $event->getName(), $memberAccount->getName());
        
        return $email;
    }

}

?>
