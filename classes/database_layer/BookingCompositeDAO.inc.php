<?php

/*
select club.name as clubName, account.name as accountName, activity.activityName as activityName from club 
inner join account on club.id = account.clubID
inner join booking on account.id = booking.userID
inner join bookingactivity on booking.id = bookingactivity.bookingID
inner join activity on bookingactivity.activityID = activity.id
where club.id = 1

*/

require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/BookingCompositeFactory.inc.php");

class BookingCompositeDAO extends DatabaseAccessObject {

	public function __construct() {
		parent::__construct();
		
		//These two are largely irrelvenat in this class
		$this->tableName = 'booking';
		$this->foreigKey = 'bookingActivity';
	}

	 protected function AssignValues($row) {
        $valueObject = BookingCompositeFactory::CreateValueObject();
		if(isset($row[BookingCompositeVO::$dbUserId]))
			$valueObject->setUserId($row[BookingCompositeVO::$dbUserId]);
			
		if(isset($row[BookingCompositeVO::$dbUserName]))	
			$valueObject->setUserName($row[BookingCompositeVO::$dbUserName]);
			
		if(isset($row[BookingCompositeVO::$dbEmail]))	
			$valueObject->setEmail($row[BookingCompositeVO::$dbEmail]);
		
		if(isset($row[BookingCompositeVO::$dbBookingId]))
			$valueObject->setBookingId($row[BookingCompositeVO::$dbBookingId]);
		
		if(isset($row[BookingCompositeVO::$dbActivityId]))
			$valueObject->setActivityId($row[BookingCompositeVO::$dbActivityId]);
		
		if(isset($row[BookingCompositeVO::$dbActivityName]))
			$valueObject->setActivityName($row[BookingCompositeVO::$dbActivityName]);
		
		if(isset($row[BookingCompositeVO::$dbActivityId]))
			$valueObject->setActivityId($row[BookingCompositeVO::$dbActivityId]);
		
		if(isset($row[BookingCompositeVO::$dbActivityName]))
			$valueObject->setActivityName($row[BookingCompositeVO::$dbActivityName]);
		
		if(isset($row[BookingCompositeVO::$dbfoodChoiceId]))
			$valueObject->setFoodChoiceId($row[BookingCompositeVO::$dbfoodChoiceId]);

		if(isset($row[BookingCompositeVO::$dbfoodChoiceName]))
			$valueObject->setFoodChoiceName($row[BookingCompositeVO::$dbfoodChoiceName]);

		if(isset($row[BookingCompositeVO::$dbfoodTypeId]))
			$valueObject->setFoodTypeId($row[BookingCompositeVO::$dbfoodTypeId]);

		if(isset($row[BookingCompositeVO::$dbfoodTypeName]))
			$valueObject->setFoodTypeName($row[BookingCompositeVO::$dbfoodTypeName]);		

		if(isset($row[BookingCompositeVO::$dbClubName]))
			$valueObject->setClubName($row[BookingCompositeVO::$dbClubName]);			
		
		if(isset($row[BookingCompositeVO::$dbDietaryReq]))
			$valueObject->setDietaryReq($row[BookingCompositeVO::$dbDietaryReq]);	
				
		if(isset($row[BookingCompositeVO::$dbMedicalCond]))
			$valueObject->setMedicalConditions($row[BookingCompositeVO::$dbMedicalCond]);				
		
        return $valueObject;
    }
	
	public function GetBookingsByClub($eventId, $clubId) {
		$sql = "select  account.id as accountId, account.name as accountName, booking.id as bookingId, activity.id as activityId, activity.activityName as activityName, club.id as clubId, club.name as clubName from club 
				inner join account on club.id = account.clubID
				inner join booking on account.id = booking.userID
				inner join bookingactivity on booking.id = bookingactivity.bookingID
				inner join activity on bookingactivity.activityID = activity.id
                inner join activitypage on activity.activityPageId = activitypage.id
                inner join event on event.activityPageId = activitypage.id       
				where club.id = :clubId and event.id = :eventId
				order by activity.id ASC";
				
		$this->valueArray = array();
		$this->valueArray[":clubId"] = $clubId;
		$this->valueArray[":eventId"] = $eventId;
		$valueObjects = $this->ExecuteQuery($sql, true);
	
		return $valueObjects;
	}
	
	public function GetFoodChoicesByType($foodChoiceId) {
		$sql = "SELECT a.name as accountName, a.email as accountEmail, c.id as clubId, c.name as clubName, fc.name as foodChoiceName from bookingfoodchoice as bfc
				INNER JOIN foodchoice as fc on bfc.foodChoiceID = fc.id
				INNER JOIN booking as b on bfc.bookingID = b.id
				INNER JOIN account as a on b.userID = a.id
				INNER JOIN club as c on a.clubID = c.id
                where fc.id = :foodChoice
				order by c.id ASC";
				
		$this->valueArray = array();
		$this->valueArray[":foodChoice"] = $foodChoiceId;
		$valueObjects = $this->ExecuteQuery($sql, true);
		
		return $valueObjects;
	}
	
	public function GetFoodChoicesByClub($eventId, $foodTypeId, $clubId) {
		$sql = "SELECT ft.id as foodTypeId, ft.foodTypeName as foodTypeName, a.id as accountId, a.name as accountName, a.email as accountEmail, a.dietaryReq as dietaryRequirements, a.medicalCond as medicalConditions, fc.id as foodChoiceId, fc.name as foodChoiceName, c.id as clubId, c.name as clubName from bookingfoodchoice as bfc
				INNER JOIN foodchoice as fc on bfc.foodChoiceID = fc.id
				INNER JOIN foodtype as ft on fc.foodTypeID = ft.id
				INNER JOIN booking as b on bfc.bookingID = b.id
				INNER JOIN account as a on b.userID = a.id
				INNER JOIN club as c on a.clubID = c.id
				INNER JOIN bookingactivity on b.id = bookingactivity.bookingID
				INNER JOIN activity on bookingactivity.activityID = activity.id
                INNER JOIN activitypage on activity.activityPageId = activitypage.id
                INNER JOIN event on event.activityPageId = activitypage.id
				WHERE ft.id = :foodTypeId and event.id = :eventId and c.id = :clubId";
				
		$this->valueArray = array();
		$this->valueArray[":foodTypeId"] = $foodTypeId;
		$this->valueArray[":eventId"] = $eventId;
		$this->valueArray[":clubId"] = $clubId;
		$valueObjects = $this->ExecuteQuery($sql, true);
		
		return $valueObjects;
	}
	
	protected function GenerateUpdateSQL($valueObject) {
		return "";
	}
    
	protected function GenerateInsertSQL($valueObject) {
		return "";
	}
}