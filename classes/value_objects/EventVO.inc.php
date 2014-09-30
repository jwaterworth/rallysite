<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of EventVO
 *
 * @author James
 */
class EventVO implements IValueObject{
    
    private $id;
    
    private $name;
    
    private $summary;
    
    private $information;
    
    private $logoLoc;
    
    private $bookingInfoID;
	
	private $startDate;
	
	private $endDate;
    
    private $activityPageID;
    
    public static $dbId = "id";
    
    public static $dbName = "eventName";
    
    public static $dbSummary = "eventSummary";
    
    public static $dbInformation = "eventInformation";
    
    public static $dbLogoLoc = "eventLogoLoc";
    
    public static $dbBookingInfoID = 'bookingInfoID';
	
	public static $dbStartDate = 'startDate';
	
	public static $dbEndDate = 'endDate';
    
    public static $dbActivityPageID = 'activityPageID';
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setSummary($summary) {
        $this->summary = $summary;
    }

    public function setInformation($information) {
        $this->information = $information;
    }

    public function setLogoLoc($logoLoc) {
        $this->logoLoc = $logoLoc;
    }
	
	public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }
	
	public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }
    
    public function setBookingInfoID($bookingInfoID) {
        $this->bookingInfoID = $bookingInfoID;
    }

    public function setActivityPageID($activityPageID) {
        $this->activityPageID = $activityPageID;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSummary() {
        return $this->summary;
    }

    public function getInformation() {
        return $this->information;
    }

    public function getLogoLoc() {
        return $this->logoLoc;
    }
	
	public function getStartDate() {
        return $this->startDate;
    }
	
	public function getEndDate() {
        return $this->endDate;
    }
    
    public function getBookingInfoID() {
        return $this->bookingInfoID;
    }

    public function getActivityPageID() {
        return $this->activityPageID;
    }
}

?>
