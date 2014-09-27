<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of FoodChoiceVO
 *
 * @author James
 */
class FoodChoiceVO {
    
    private $id;
    
    private $name;
    
    private $notes;
    
    private $foodTypeID;
    
    public static $dbId = 'id';
    
    public static $dbName = 'name';
    
    public static $dbNotes = 'notes';
    
    public static $dbFoodTypeID = 'foodTypeID';
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
    }

    public function setFoodTypeID($foodTypeID) {
        $this->foodTypeID = $foodTypeID;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function getFoodTypeID() {
        return $this->foodTypeID;
    }
    
}

?>
