<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/FoodChoiceFactory.inc.php");

/**
 * Description of FoodChoiceDAO
 *
 * @author James
 */
class FoodChoiceDAO extends DatabaseAccessObject{
    
    public function __construct() {
        parent::__construct();
        $this->tableName = 'FoodChoice';
        $this->foreignKey = FoodChoiceVO::$dbFoodTypeID;
    }

    protected function AssignValues($row) {
        $valueObject = FoodChoiceFactory::CreateValueObject();
        
        $valueObject->setId($row[FoodChoiceVO::$dbId]);
        $valueObject->setName($row[FoodChoiceVO::$dbName]);
        $valueObject->setNotes($row[FoodChoiceVO::$dbNotes]);
        $valueObject->setFoodTypeID($row[FoodChoiceVO::$dbFoodTypeID]);
        
        return $valueObject;
    }
    
    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                FoodChoiceVO::$dbId.",".
                FoodChoiceVO::$dbName.",".
                FoodChoiceVO::$dbNotes.",".
                FoodChoiceVO::$dbFoodTypeID.") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getName())."','".
                $this->mysqli->real_escape_string($valueObject->getNotes())."','".
                $this->mysqli->real_escape_string($valueObject->getFoodTypeID())."')"; 
        
        return $sql;
    }
    
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                /*FoodChoiceVO::$dbId."='".
                $this->mysqli->real_escape_string($valueObject->getId())."',".*/
                FoodChoiceVO::$dbName."='".
                $this->mysqli->real_escape_string($valueObject->getName())."',".
                FoodChoiceVO::$dbNotes."='".
                $this->mysqli->real_escape_string($valueObject->getNotes())."',".
                FoodChoiceVO::$dbFoodTypeID."='".
                $this->mysqli->real_escape_string($valueObject->getFoodTypeID())."' ".
                "WHERE ".FoodChoiceVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
}

?>
