<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of FoodTypeVO
 *
 * @author Bernard
 */
class FoodTypeVO implements IValueObject {
    
    private $id;
    
    private $foodTypeName;
    
    private $bookingInfoID;
    
    public static $dbId = 'id';
    
    public static $dbFoodTypeName = 'foodTypeName';
    
    public static $dbBookingInfoID = 'bookingInfoID';
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setFoodTypeName($foodTypeName) {
        $this->foodTypeName = $foodTypeName;
    }

    public function setBookingInfoID($bookingInfoID) {
        $this->bookingInfoID = $bookingInfoID;
    }

    public function getId() {
        return $this->id;
    }

    public function getFoodTypeName() {
        return $this->foodTypeName;
    }

    public function getBookingInfoID() {
        return $this->bookingInfoID;
    }
}

?>
