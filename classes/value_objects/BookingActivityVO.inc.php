<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of BookingActivityVO
 *
 * @author James
 */
class BookingActivityVO implements IValueObject{
    
    private $id;
    
    private $bookingID;
    
    private $activityID;
    
    private $priority;
    
    public static $dbId = 'id';
            
    public static $dbBookingID = 'bookingID';
    
    public static $dbActivityID = 'activityID';
    
    public static $dbPriority = 'priority';
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setBookingID($bookingID) {
        $this->bookingID = $bookingID;
    }

    public function setActivityID($activityID) {
        $this->activityID = $activityID;
    }

    public function setPriority($priority) {
        $this->priority = $priority;
    }

    public function getId() {
        return $this->id;
    }

    public function getBookingID() {
        return $this->bookingID;
    }

    public function getActivityID() {
        return $this->activityID;
    }

    public function getPriority() {
        return $this->priority;
    }

}

?>
