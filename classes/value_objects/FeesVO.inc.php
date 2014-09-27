<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of FeesVO
 *
 * @author James
 */
class FeesVO implements IValueObject{
    
    private $id;
    
    private $fee;
    
    private $deadline;
    
    private $bookingInfoID;
    
    public static $dbId = 'id';
    
    public static $dbFee = 'fee';
    
    public static $dbDeadline = 'deadline';
    
    public static $dbBookingInfoID = 'bookingInfoID';
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setFee($fee) {
        $this->fee = $fee;
    }

    public function setDeadline($deadline) { 
        $this->deadline = $deadline;
    }

    public function setBookingInfoID($bookingInfoID) {
        $this->bookingInfoID = $bookingInfoID;
    }

    public function getId() {
        return $this->id;
    }

    public function getFee() {
        return $this->fee;
    }

    public function getDeadline() {
        $dateArray =  date_parse_from_format('Y-m-d', $this->deadline);
        $date =  $dateArray['day'] . '/' . $dateArray['month'] . '/' . $dateArray['year'];
        return $date;
    }

    public function getBookingInfoID() {
        return $this->bookingInfoID;
    }

}

?>
