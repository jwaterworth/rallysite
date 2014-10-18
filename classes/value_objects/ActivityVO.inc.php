<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of ActivityVO
 *
 * @author Bernard
 */
class ActivityVO implements IValueObject {
    
    private $id;
    
    private $activityName;
    
    private $activityDescription;
    
    private $activityCost;
    
    private $activityCapacity;
    
    private $activityImageLoc;
    
    private $activityPageID;
    
    public static $dbId = "id";
    
    public static $dbActivityName = "activityName";
    
    public static $dbActivityDescription = "activityDescription";
    
    public static $dbActivityCost = "activityCost";
    
    public static $dbActivityCapacity = "activityCapacity";
    
    public static $dbActivityImageLoc = "activityImageLoc";
    
    public static $dbActivityPageID = "activityPageID";
    
    public function setId($id) {
        $this->id = (int)$id;
    }

    public function setActivityName($activityName) {
        $this->activityName = $activityName;
    }

    public function setActivityDescription($activityDescription) {
        $this->activityDescription = $activityDescription;
    }

    public function setActivityCost($activityCost) {
        $this->activityCost = $activityCost;
    }

    public function setActivityCapacity($activityCapacity) {
        $this->activityCapacity = $activityCapacity;
    }
    
    public function setActivityImageLoc($activityImageLoc) {
        $this->activityImageLoc = $activityImageLoc;
    }

    public function setActivityPageID($activityPageID) {
        $this->activityPageID = (int)$activityPageID;
    }

    public function getId() {
        return $this->id;
    }

    public function getActivityName() {
        return $this->activityName;
    }

    public function getActivityDescription() {
        return $this->activityDescription;
    }

    public function getActivityCost() {
        return $this->activityCost;
    }

    public function getActivityCapacity() {
        return $this->activityCapacity;
    }
    
    public function getActivityImageLoc() {
        return $this->activityImageLoc;
    }

    public function getActivityPageID() {
        return $this->activityPageID;
    }
}

?>
