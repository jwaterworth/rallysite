<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");
/**
 * Description of Account
 *
 * @author James
 */
class AccountVO implements IValueObject{
    /*
     * @var $userID int
     * Unique ID number for account
     */
    private $id;
	/*
	 * Account holder's hashed password.
	 */
	private $password;
	/*
	 * Account holder's salt
	 */
	private $userSalt;
    /*
     * Account holder's name
     */
    private $name;
    /*
     * Account holder's DoB
     */
    private $dateOfBirth;
    /*
     * Account holder's email address
     */
    private $email;
    /*
     * Account holder's phone number
     */
    private $phoneNumber;
    /*
     * Acccount holder's address
     */
    private $address;
    /*
     * Account holder's emergency contact's name
     */
    private $emergName;
    /*
     * Account holder's emergency contact's adddress
     */
    private $emergAddress;
    /*
     * Account holder's emergency contact's phone number
     */
    private $emergPhone;
	/*
     * Account holder's relationship to emergency contact
     */
	private $emergRelationship;
    /*
     * Dietary requirements of account holder
     */
    private $dietaryReq;
    /*
     * Medical conditions of account holder
     */
    private $medicalConditions;
    /*
     * Member's club ID
     */
    private $clubID;
    /*
     * Member's account type MEMBER, CLUB REP, EVENT EXEC, SSAGO EXEC
     */
    private $accountTypeID;
    
    /*
     * Database column names
     */
    public static $dbId ="id";
	
	public static $dbPassword ="password";
	
	public static $dbUserSalt = "userSalt";

    public static $dbName = "name";

    public static $dbDateOfBirth = "dateOfBirth";

    public static $dbEmail = "email";

    public static $dbPhoneNumber = "phoneNumber";
    
    public static $dbAddress = "address";

    public static $dbEmergName = "emergName";

    public static $dbEmergAddress = "emergAddress";

    public static $dbEmergPhone = "emergPhone";
	
	public static $dbEmergRelationship = "emergRel";

    public static $dbDietaryReq = "dietaryReq";

    public static $dbMedicalConditions = "medicalCond";
    
    public static $dbClubID = "clubID";
    
    public static $dbAccountTypeID = 'accountTypeID';
    
    public function setId($id) {
        $this->id = $id;
    }
	
	public function setPassword($password) {
        $this->password = $password;
    }
	
	public function setUserSalt($userSalt) {
        $this->userSalt = $userSalt;
    }
    
    public function setName($name) {
        $this->name = $name;
    }

    public function setDateOfBirth($dateOfBirth) {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }
    
    public function setAddress($address) {
        $this->address = $address;
    }

    public function setEmergName($emergName) {
        $this->emergName = $emergName;
    }

    public function setEmergAddress($emergAddress) {
        $this->emergAddress = $emergAddress;
    }

    public function setEmergPhone($emergPhone) {
        $this->emergPhone = $emergPhone;
    }
	
	public function setEmergRelationship($emergRel) {
        $this->emergRelationship = $emergRel;
    }

    public function setDietaryReq($dietaryReq) {
        $this->dietaryReq = $dietaryReq;
    }

    public function setMedicalConditions($medicalConditions) {
        $this->medicalConditions = $medicalConditions;
    }
    
    public function setClubID($clubID) {
        $this->clubID = $clubID;
    }
    
    public function setAccountTypeID($accountTypeID) {
        $this->accountTypeID = $accountTypeID;
    }

    public function getId() {
        return $this->id;
    }
	
	public function getPassword() {
        return $this->password;
    }
	
	public function getUserSalt() {
        return $this->userSalt;
    }

    public function getName() {
        return $this->name;
    }

    public function getDateOfBirth() {
       
        return $this->dateOfBirth;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getEmergName() {
        return $this->emergName;
    }

    public function getEmergAddress() {
        return $this->emergAddress;
    }
	
	public function getEmergRelationship() {
        return $this->emergRelationship;
    }

    public function getEmergPhone() {
        return $this->emergPhone;
    }

    public function getDietaryReq() {
        return $this->dietaryReq;
    }

    public function getMedicalConditions() {
        return $this->medicalConditions;
    }
    
    public function getClubID() {
        return $this->clubID;
    }
    
    public function getAccountTypeID() {
        return $this->accountTypeID;
    }


}

?>
