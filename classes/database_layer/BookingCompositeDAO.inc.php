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
		
        $valueObject->setUserId($row[BookingCompositeVO::$dbUserId]);
        $valueObject->setUserName($row[BookingCompositeVO::$dbUserName]);
        $valueObject->setBookingId($row[BookingCompositeVO::$dbBookingId]);
        $valueObject->setActivityId($row[BookingCompositeVO::$dbActivityId]);
		$valueObject->setActivityName($row[BookingCompositeVO::$dbActivityName]);
        $valueObject->setActivityId($row[BookingCompositeVO::$dbActivityId]);
		$valueObject->setActivityName($row[BookingCompositeVO::$dbActivityName]);
        
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
	
	protected function GenerateUpdateSQL($valueObject) {
		return "";
	}
    
	protected function GenerateInsertSQL($valueObject) {
		return "";
	}
}