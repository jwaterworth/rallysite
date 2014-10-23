<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");


class BookingCompositeVO implements IValueObject {
	
	private $userId;
	
	private $userName;
	
	private $bookingId;
	
	private $activityId;
	
	private $activityName;
	
	private $clubName;
	
	private $clubId;
	
	public static $dbUserId = 'accountId';
    
    public static $dbUserName = 'accountName';
    
    public static $dbBookingId = 'bookingId';
    
    public static $dbActivityId = 'activityId';
	
	public static $dbActivityName = 'activityName';
	
	public static $dbClubId = 'clubId';
	
	public static $dbClubName = 'clubName';
	
	public function setId($id) {
    }
	
	public function setUserId($userId) {
        $this->userId = $userId;
    }
	
	public function setUserName($userName) {
        $this->userName = $userName;
    }
	
	public function setBookingId($bookingId) {
        $this->bookingId = $bookingId;
    }
	
	public function setActivityId($activityId) {
        $this->activityId = $activityId;
    }
	
	public function setActivityName($activityName) {
        $this->activityName = $activityName;
    }
	
	public function setClubId($clubId) {
        $this->clubId = $$clubId;
    }
	
	public function setClubName($clubName) {
        $this->clubName = $clubName;
    }
	
	public function getId() {
		return "";
	}	
	
	public function getUserId() {
        return $this->userId;
    }
	
	public function getUserName() {
        return $this->userName;
    }
	
	public function getBookingId() {
        return $this->bookingId;
    }
	
	public function getActivityId() {
        return $this->activityId;
    }
	
	public function getActivityName() {
        return $this->activityName;
    }
	
	public function getClubId() {
        return $this->clubId;
    }
	
	public function getClubName() {
        return $this->clubName;
    }
}