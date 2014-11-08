<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");


class BookingCompositeVO implements IValueObject {
	
	private $userId;
	
	private $userName;
	
	private $email;
	
	private $bookingId;
	
	private $activityId;
	
	private $activityName;
	
	private $clubName;
	
	private $clubId;
	
	private $foodChoiceId;
	
	private $foodChoiceName;
	
	private $foodTypeId;
	
	private $foodTypeName;	
	
	private $dietaryReq;
	
	private $medicalCond;
	
	public static $dbUserId = 'accountId';
    
    public static $dbUserName = 'accountName';
	
	public static $dbEmail = 'accountEmail';
    
    public static $dbBookingId = 'bookingId';
    
    public static $dbActivityId = 'activityId';
	
	public static $dbActivityName = 'activityName';
	
	public static $dbClubId = 'clubId';
	
	public static $dbClubName = 'clubName';
	
	public static $dbfoodChoiceId = 'foodChoiceId';
	
	public static $dbfoodChoiceName = 'foodChoiceName';
	
	public static $dbfoodTypeId = 'foodTypeId';
	
	public static $dbfoodTypeName = 'foodTypeName';	
	
	public static $dbDietaryReq = 'dietaryRequirements';
	
	public static $dbMedicalCond = 'medicalConditions';
	
	public function setId($id) {
    }
	
	public function setUserId($userId) {
        $this->userId = $userId;
    }
	
	public function setUserName($userName) {
        $this->userName = $userName;
    }
	
	public function setEmail($email) {
        $this->email = $email;
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
	
	public function setFoodChoiceId($foodChoiceId) {
        $this->foodChoiceId = $foodChoiceId;
    }
	
	public function setFoodChoiceName($foodChoiceName) {
        $this->foodChoiceName = $foodChoiceName;
    }
	
	public function setFoodTypeId($foodTypeId) {
        $this->foodTypeId = $foodTypeId;
    }
	
	public function setFoodTypeName($foodTypeName) {
        $this->foodTypeName = $foodTypeName;
    }
	
	public function setDietaryReq($dietaryReq) {
        $this->dietaryReq = $dietaryReq;
    }
	
	public function setMedicalConditions($medicalCond) {
        $this->medicalCond = $medicalCond;
    }
	
	public function getId() {
		return "";
	}	
	
	public function getUserId() {
        return $this->userId;
    }
	
	public function getEmail() {
        return $this->email;
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
	
	public function getFoodChoiceId() {
        return $this->foodChoiceId;
    }
	
	public function getFoodChoiceName() {
        return $this->foodChoiceName;
    }
	
	public function getFoodTypeId() {
        return $this->foodTypeId;
    }
	
	public function getFoodTypeName() {
        return $this->foodTypeName;
    }
	
	public function getDietaryReq() {
        return $this->dietaryReq;
    }
	
	public function getMedicalConditions() {
        return $this->medicalCond;
    }
}