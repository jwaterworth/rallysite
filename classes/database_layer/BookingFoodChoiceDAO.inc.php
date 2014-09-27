<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/BookingFoodChoiceFactory.inc.php");

/**
 * Description of BookingFoodChoiceDAO
 *
 * @author James
 */
class BookingFoodChoiceDAO extends DatabaseAccessObject{
    
    public function __construct() {
        parent::__construct();
        $this->tableName = 'BookingFoodChoice';
        $this->foreignKey = null;
    }

    protected function AssignValues($row) {
        $valueObject = BookingFoodChoiceFactory::CreateValueObject();
        
        $valueObject->setId($row[BookingFoodChoiceVO::$dbId]);
        $valueObject->setBookingID($row[BookingFoodChoiceVO::$dbBookingID]);
        $valueObject->setFoodChoiceID($row[BookingFoodChoiceVO::$dbFoodChoiceID]);
        
        return $valueObject;
    }
    
    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                BookingFoodChoiceVO::$dbId.",".
                BookingFoodChoiceVO::$dbBookingID.",".
                BookingFoodChoiceVO::$dbFoodChoiceID.") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getBookingID())."','".
                $this->mysqli->real_escape_string($valueObject->getFoodChoiceID())."')"; 
        
        return $sql;
    }
    
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                /*BookingFoodChoiceVO::$dbId."='".
                $this->mysqli->real_escape_string($valueObject->getId())."',".*/
                BookingFoodChoiceVO::$dbBookingID."='".
                $this->mysqli->real_escape_string($valueObject->getBookingID())."',".
                BookingFoodChoiceVO::$dbFoodChoiceID."='".
                $this->mysqli->real_escape_string($valueObject->getFoodChoiceID())."' ".
                "WHERE ".BookingInfoVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
}

?>
