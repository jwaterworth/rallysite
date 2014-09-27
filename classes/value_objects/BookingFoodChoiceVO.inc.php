<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of BookingFoodChoice
 *
 * @author James
 */
class BookingFoodChoiceVO implements IValueObject{
    
    private $id;
    
    private $foodChoiceID;
    
    private $bookingID;
    
    public static $dbId = 'id';
    
    public static $dbFoodChoiceID = 'foodChoiceID';
    
    public static $dbBookingID = 'bookingID';
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setFoodChoiceID($foodChoiceID) {
        $this->foodChoiceID = $foodChoiceID;
    }

    public function setBookingID($bookingID) {
        $this->bookingID = $bookingID;
    }

    public function getId() {
        return $this->id;
    }

    public function getFoodChoiceID() {
        return $this->foodChoiceID;
    }

    public function getBookingID() {
        return $this->bookingID;
    }

}

?>
