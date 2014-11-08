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
        
        $accountData = LogicFactory::CreateObject("Accounts");
        
        $activityData = LogicFactory::CreateObject("Activities");
        $fileName = null;
		
        //Get and print data
        try {
            $activityVO = $activityData->GetActivity($activityID);
            $fileName = $activityVO->getActivityName()." Participant List.csv";
            $filePath = DOWNLOADS_PATH.$fileName;
            $handle = fopen($filePath, 'w');
            
            $data = array("Activity: ". $activityVO->getActivityName() . " Participant List");
            fputcsv($handle, $data);	
			fputcsv($handle, array(""));
			fputcsv($handle, array(""));
            
            $activity = array();

            $activity['spaces'] = $activityVO->getActivityCapacity();
            $activity['number'] = $activityData->GetActivityNumber($activityVO);

            $data = array("Participants", $activity['number']);
            fputcsv($handle, $data);
            $data = array("Capacity", $activity['spaces']);
            fputcsv($handle, $data);
			fputcsv($handle, array(""));
			fputcsv($handle, array(""));
            
            $participants = $activityData->GetActivityParticipants($activityVO);
            
            if(sizeof($participants) < 1) {
                $data = array("No Participants for this activity");
                fputcsv($handle, $data);
				fputcsv($handle, array(""));
            }
            
            //Label columns
			$header = array("Name","Email","Phone","Date of Birth","Address","Medical Conditions","Dietary Requirements","Emergency Contact Name","Emergency Contact Phone","Emergency Contact Address");
			fputcsv($handle, $header);
            foreach($participants as $bookingVO) {
                $participant = array();
                $accountVO = $bookingData->GetBookingAccount($bookingVO);

                //Booking details
                $participant['bookingFee'] = $bookingVO->getBookingFee();

                //Account details
                $participant['name'] = $accountVO->getName();
                $participant['email'] = $accountVO->getEmail();
                $participant['phone'] = "'". $accountVO->getPhoneNumber()."'";
                $participant['dob'] = $accountVO->getDateOfBirth();
                $participant['address'] = $accountVO->getAddress();
                $participant['medicalCond'] = $accountVO->getMedicalConditions();
                $participant['dietaryReq'] = $accountVO->getDietaryReq();
                $participant['emergName'] = $accountVO->getEmergName();
                $participant['emergPhone'] = "'".$accountVO->getEmergPhone()."'";
                $participant['emergAddress'] = $accountVO->getEmergAddress();

                //Club details
                $club = $accountData->GetMemberClub($accountVO);
                $participant['clubName'] = $club->getName();
                //Account type
                $accountType = $accountData->GetMemberType($accountVO);
                $participant['accountType'] = $accountType->getAccountTypeName();
                
				$dataArray = array($participant['name'],$participant['email'],$participant['phone'],$participant['dob'],
												$participant['address'],$participant['medicalCond'],$participant['dietaryReq'],
													$participant['emergName'],$participant['emergPhone'],$participant['emergAddress']);
				fputcsv($handle, $dataArray);
					
            }
            
        } catch (Exception $e) {
			Logging::Error(ERRORS_LOGFILE, "CSV Generator", "CreateActivityListCSV", $e->getMessage(), json_encode(array("activityID" => $activityID)));			 
        }
		
		fclose($handle);
		return $fileName;
    }
    
    public function CreateParticpantsCSV() {
        $fileName = $this->event->getName()." Participant List.csv";
        $filePath = DOWNLOADS_PATH.$fileName;
        $handle = fopen($filePath, 'w');
        
        $bookingData = LogicFactory::CreateObject("Bookings");
        
        $accountData = LogicFactory::CreateObject("Accounts");
        
        $activityData = LogicFactory::CreateObject("Activities");
        
        $data = array($this->event->getName() . ' - Master Participant List');
        fputcsv($handle, $data);
        
        try {
            //Get all clubs
            $clubs = $accountData->GetAllClubs();
            
            //foreach club
            foreach($clubs as $clubVO) {
                $club = array();
                
                $club['name'] = $clubVO->getName();
                
				fputcsv($handle, array(""));
				fputcsv($handle, array(""));
                $data = array("Club - ". $club['name'] . "");
				fputcsv($handle, $data);
				fputcsv($handle, array(""));
				fputcsv($handle, array(""));
				
                //fwrite($handle, $data);
                $clubBookings = $bookingData->GetClubBookings($this->event, $clubVO);
                
                //If no bookings, carry on to next club
                if(sizeof($clubBookings) < 1) {
                    $data = array("No bookings found for this club");
                    fputcsv($handle, $data);
                    continue;
                }
                
                //Label columns
                $header = array("Name","Activity","Paid?","Email","Phone","Date of Birth","Address","Medical Conditions","Dietary Requirements","Emergency Contact Name","Emergency Contact Phone","Emergency Contact Address");                             
				
				fputcsv($handle, $header);
                
                foreach($clubBookings as $bookingVO) {
                    $participant = array();
                    
                    $accountVO = $bookingData->GetBookingAccount($bookingVO);
                    $activityVO = $bookingData->GetBookingActivity($bookingVO);
                    
                    //Account details
                    $participant['name'] = $accountVO->getName();
                    $participant['email'] = $accountVO->getEmail();
                    $participant['phone'] = "'" . $accountVO->getPhoneNumber()."'";
                    $participant['dob'] = $accountVO->getDateOfBirth();
                    $participant['address'] = $accountVO->getAddress();
                    $participant['medicalCond'] = $accountVO->getMedicalConditions();
                    $participant['dietaryReq'] = $accountVO->getDietaryReq();
                    $participant['emergName'] = $accountVO->getEmergName();
                    $participant['emergPhone'] = "'" . $accountVO->getEmergPhone()."'";
                    $participant['emergAddress'] = $accountVO->getEmergAddress();
                    
                    //Activity details
                    $participant['activity'] = $activityVO->getActivityName();
					$participant['paid'] = $bookingVO->getPaid() ? "Paid" : "Awaiting Payment";
                    
					$dataArray = array($participant['name'],$participant['activity'], $participant['paid'],$participant['email'],$participant['phone'],$participant['dob'],
                            $participant['address'],$participant['medicalCond'],$participant['dietaryReq'],
                            $participant['emergName'],$participant['emergPhone'],$participant['emergAddress']);
					
					fputcsv($handle, $dataArray);                    
                }     
            }
            
        } catch (Exception $e) {
            Logging::Error(ERRORS_LOGFILE, "CSV Generator", "CreateParticpantsCSV", $e->getMessage(), null);			 
        }
        
        fclose($handle);
        return $fileName;
    }
	
	public function CreateFoodListByTypeCSV($foodTypeId) {
		$fileName = null;
		$filePath = null;
		$handle = null;       
        
        $bookingData = LogicFactory::CreateObject("Bookings");
		
		$accountData = LogicFactory::CreateObject("Accounts");
		
		try {
			$foodType = $bookingData->GetFoodType($foodTypeId);			
			
			$fileName = $foodType->getFoodTypeName()." Food Choices List.csv";
			$filePath = DOWNLOADS_PATH.$fileName;
			$handle = fopen($filePath, 'w');
			
			fputcsv($handle, array($foodType->getFoodTypeName()." Food Choice List"));
		
			//Get all clubs
            $clubs = $accountData->GetAllClubs();
			$bookingInfo = $bookingData->GetBookingInfo($this->event);
			$foodType = FoodTypeFactory::CreateValueObject();
			$foodType->setId($foodTypeId);
			$foodChoices = $bookingData->GetFoodChoices($foodType);
            
            //foreach club
            foreach($foodChoices as $foodChoiceVO) {
                $foodChoiceArr = array();
                
                $foodChoiceArr['name'] = $foodChoiceVO->getName();
                
				$bookingFoodChoices = $bookingData->GetBookingFoodChoicesByChoice($foodChoiceVO->getId());
				
				fputcsv($handle, array(""));
				fputcsv($handle, array(""));
				fputcsv($handle, array("Food Choice - ". $foodChoiceArr['name'] . " (" . sizeof($bookingFoodChoices)  . ")"));
				fputcsv($handle, array(""));
				
				
				
				//If no bookings, carry on to next club
				if(sizeof($bookingFoodChoices) < 1) {
					$data = array("No participants have selected this option.");
					fputcsv($handle, $data);
					continue;
				}
				
				//Label columns
				$header = array("Name","Email","Club","Dietary Requirements", "Medical Conditions");                             
				
				fputcsv($handle, $header);
				
				foreach($bookingFoodChoices as $bookingFoodChoice) {
					$bfcArr = array();
											
					//Account details
					$bfcArr['name'] = $bookingFoodChoice->getUserName();
					$bfcArr['email'] = $bookingFoodChoice->getEmail();
					$bfcArr['club'] = $bookingFoodChoice->getClubName();	
					$bfcArr['dietary'] = $bookingFoodChoice->getDietaryReq();
					$bfcArr['medical'] = $bookingFoodChoice->getMedicalConditions();
					
					$dataArray = array($bfcArr['name'], $bfcArr['email'], $bfcArr['club'], $bfcArr['dietary'], $bfcArr['medical']);
					
					fputcsv($handle, $dataArray);                    
				} 
            }
		} catch(Exception $e) {
			Logging::Error(ERRORS_LOGFILE, "CSV Generator", "CreateParticpantsCSV", $e->getMessage(), json_encode(array("foodTypeId" => $foodTypeId)));			 
		}
		
		return $fileName;
	}
	
	public function CreateClubFoodListCSV() {
		$fileName = $this->event->getName()." Food Choice By Club List.csv";
        $filePath = DOWNLOADS_PATH.$fileName;
        $handle = fopen($filePath, 'w');
        
        $bookingData = LogicFactory::CreateObject("Bookings");
		
		$accountData = LogicFactory::CreateObject("Accounts");
		
		try {
			//Get all clubs
            $clubs = $accountData->GetAllClubs();
			$bookingInfo = $bookingData->GetBookingInfo($this->event);
			$foodTypes = $bookingData->GetFoodTypes($bookingInfo);
			
			fputcsv($handle, array("Club Food Choices"));
			fputcsv($handle, array(""));
            
            //foreach club
            foreach($clubs as $clubVO) {
                $club = array();
                
                $club['name'] = $clubVO->getName();
                
				fputcsv($handle, array(""));
				fputcsv($handle, array(""));
                $data = array("Club - ". $club['name'] . "");
				fputcsv($handle, $data);
				
				foreach($foodTypes as $foodType) {			
					$clubBookingFoodChoices = $bookingData->GetBookingFoodChoicesByTypeAndClub($this->event->getId(), $foodType->getId(), $clubVO->getId());
					
					//Food Type
					fputcsv($handle, array(""));
					fputcsv($handle, array($foodType->getFoodTypeName() . " (". sizeof($clubBookingFoodChoices) . ")"));
					fputcsv($handle, array(""));
					
					//If no bookings, carry on to next club
					if(sizeof($clubBookingFoodChoices) < 1) {
						$data = array("No bookings found for this club");
						fputcsv($handle, $data);
						continue;
					}
					
					//Label columns
					fputcsv($handle, array("Name","Email","Food Choice", "Dietary Requirements", "Medical Conditions"));
					
					foreach($clubBookingFoodChoices as $bookingFoodChoice) {
						$foodChoice = array();
												
						//Account details
						$foodChoice['name'] = $bookingFoodChoice->getUserName();
						$foodChoice['email'] = $bookingFoodChoice->getEmail();
						$foodChoice['foodChoice'] = $bookingFoodChoice->getFoodChoiceName();		
						$foodChoice['dietary'] = $bookingFoodChoice->getDietaryReq();
						$foodChoice['medical'] = $bookingFoodChoice->getMedicalConditions();
						
						$dataArray = array($foodChoice['name'], $foodChoice['email'], $foodChoice['foodChoice'], $foodChoice['dietary'], $foodChoice['medical']);
						
						fputcsv($handle, $dataArray);                    
					}     
				}
            }
		} catch(Exception $e) {
			Logging::Error(ERRORS_LOGFILE, "CSV Generator", "CreateParticpantsCSV", $e->getMessage(), null);			 
		}
		
		return $fileName;
	}
}

?>
