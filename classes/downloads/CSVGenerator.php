<?php

/**
 * Description of CSVGenerator
 *
 * @author Bernard
 */
class CSVGenerator {
    
    private $event;

        
    function __construct(EventVO $event) {
        $this->event = $event;
    }
    
    
    public function CreateActivityListCSV($activityID) {
        $bookingData = LogicFactory::CreateObject("Bookings");
        $bookingData = new Bookings();
        
        $accountData = LogicFactory::CreateObject("Accounts");
        $accountData = new Accounts();
        
        $activityData = LogicFactory::CreateObject("Activities");
        $activityData = new Activities();
        
        //Get and print data
        try {
            $activityVO = $activityData->GetActivity($activityID);
            $fileName = $activityVO->getActivityName()." Participant List.csv";
            $filePath = DOWNLOADS_PATH.$fileName;
            $handle = fopen($filePath, 'w');
            
            $data = "Activity: " . $activityVO->getActivityName() . " Participant List\n\n";
            fwrite($handle, $data);
            
            $activity = array();

            $activity['spaces'] = $activityVO->getActivityCapacity();
            $activity['number'] = $activityData->GetActivityNumber($activityVO);

            $data = "Participants," . $activity['number'] ."\n";
            fwrite($handle, $data);
            $data = "Capacity," . $activity['spaces'] ."\n\n";
            fwrite($handle, $data);
            
            $participants = $activityData->GetActivityParticipants($activityVO);
            
            if(sizeof($participants) < 1) {
                $data = "No Participants for this activity\n";
                fwrite($handle, $data);
            }
            
            //Label columns
            $data = "Name,Email,Phone,Date of Birth,Address,Medical Conditions,Dietary Requirements, Emergency Contact Name, Phone, Address\n";               
            fwrite($handle, $data);

            foreach($participants as $bookingVO) {
                $participant = array();
                $accountVO = $bookingData->GetBookingAccount($bookingVO);

                //Booking details
                $participant['bookingFee'] = $bookingVO->getBookingFee();

                //Account details
                $participant['name'] = $accountVO->getName();
                $participant['email'] = $accountVO->getEmail();
                $participant['phone'] = $accountVO->getPhoneNumber();
                $participant['dob'] = $accountVO->getDateOfBirth();
                $participant['address'] = $accountVO->getAddress();
                $participant['medicalCond'] = $accountVO->getMedicalConditions();
                $participant['dietaryReq'] = $accountVO->getDietaryReq();
                $participant['emergName'] = $accountVO->getEmergName();
                $participant['emergPhone'] = $accountVO->getEmergPhone();
                $participant['emergAddress'] = $accountVO->getEmergAddress();

                //Club details
                $club = $accountData->GetMemberClub($accountVO);
                $participant['clubName'] = $club->getName();
                //Account type
                $accountType = $accountData->GetMemberType($accountVO);
                $participant['accountType'] = $accountType->getAccountTypeName();
                
                //Write to file
                    $data = $participant['name'].",".$participant['email'].",".$participant['phone'].",".$participant['dob'].",".
                            $participant['address'].",".$participant['medicalCond'].",".$participant['dietaryReq'].",".
                            $participant['emergName'].",".$participant['emergPhone'].",".$participant['emergAddress']."\n";
                    fwrite($handle, $data);
            }
            
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
        fclose($handle);
        return $fileName;
    }
    
    public function CreateParticpantsCSV() {
        $fileName = $this->event->getName()." Participant List.csv";
        $filePath = DOWNLOADS_PATH.$fileName;
        $handle = fopen($filePath, 'w');
        
        $bookingData = LogicFactory::CreateObject("Bookings");
        $bookingData = new Bookings();
        
        $accountData = LogicFactory::CreateObject("Accounts");
        $accountData = new Accounts();
        
        $activityData = LogicFactory::CreateObject("Activities");
        $activityData = new Activities();
        
        $data = $this->event->getName() . ' - Master Participant List\n';
        fwrite($handle, $data);
        
        try {
            //Get all clubs
            $clubs = $accountData->GetAllClubs();
            
            //foreach club
            foreach($clubs as $clubVO) {
                $club = array();
                
                $club['name'] = $clubVO->getName();
                
                $data = "\n\nClub - " . $club['name'] . "\n\n";
                fwrite($handle, $data);
                $clubBookings = $bookingData->GetClubBookings($this->event, $clubVO);
                
                //If no bookings, carry on to next club
                if(sizeof($clubBookings) < 1) {
                    $data = "No bookings found for this club\n";
                    fwrite($handle, $data);
                    continue;
                }
                
                //Label columns
                $data = "Name,Activity,Email,Phone,Date of Birth,Address,Medical Conditions,Dietary Requirements, Emergency Contact Name, Phone, Address\n";               
                fwrite($handle, $data);
                
                foreach($clubBookings as $bookingVO) {
                    $participant = array();
                    
                    $accountVO = $bookingData->GetBookingAccount($bookingVO);
                    $activityVO = $bookingData->GetBookingActivity($bookingVO);
                    
                    //Account details
                    $participant['name'] = $accountVO->getName();
                    $participant['email'] = $accountVO->getEmail();
                    $participant['phone'] = $accountVO->getPhoneNumber();
                    $participant['dob'] = $accountVO->getDateOfBirth();
                    $participant['address'] = $accountVO->getAddress();
                    $participant['medicalCond'] = $accountVO->getMedicalConditions();
                    $participant['dietaryReq'] = $accountVO->getDietaryReq();
                    $participant['emergName'] = $accountVO->getEmergName();
                    $participant['emergPhone'] = $accountVO->getEmergPhone();
                    $participant['emergAddress'] = $accountVO->getEmergAddress();
                    
                    //Activity details
                    $participant['activity'] = $activityVO->getActivityName();
                    
                    //Write to file
                    $data = $participant['name'].",".$participant['activity'].",".$participant['email'].",".$participant['phone'].",".$participant['dob'].",".
                            $participant['address'].",".$participant['medicalCond'].",".$participant['dietaryReq'].",".
                            $participant['emergName'].",".$participant['emergPhone'].",".$participant['emergAddress']."\n";
                    fwrite($handle, $data);
                    
                }     
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
        fclose($handle);
        return $fileName;
    }
    
    public function TestFile() {
        $file = DOWNLOADS_PATH."participant_list.csv";
        $handle = fopen($file, 'w');
        $data = "hello\n";
        fwrite($handle, $data);
        $data = "james\n";
        fwrite($handle, $data);
        fclose($handle);
    }

}

?>
