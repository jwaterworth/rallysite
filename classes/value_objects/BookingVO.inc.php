<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of BookingVO
 *
 * @author James
 */
class BookingVO implements IValueObject{
     
    private $id;
    
    private $userID;
    
    private $bookingFee;
    
    private $paid;
    
    public static $dbId = 'id';
    
    public static $dbUserID = 'userID';
    
    public static $dbBookingFee = 'bookingFee';
    
    public static $dbPaid = 'paid';
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setUserID($userID) {
        $this->userID = $userID;
    }
    
    public function setBookingFee($bookingFee) {
        $this->bookingFee = $bookingFee;
    }
    
    public function setPaid($paid) {
        $this->paid = $paid;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getUserID() {
        return $this->userID;
    }
    
    public function getBookingFee() {
        return $this->bookingFee;
    }
    
    public function getPaid() {
        return $this->paid;
    }

}

?>
