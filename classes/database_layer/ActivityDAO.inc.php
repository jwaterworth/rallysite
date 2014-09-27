<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/ActivityFactory.inc.php");


/**
 * Description of ActivityDAO
 *
 * @author Bernard
 */
class ActivityDAO extends DatabaseAccessObject {
    
    public function __construct() {
        parent::__construct();
        $this->tableName = "Activity";
        $this->foreignKey = ActivityVO::$dbActivityPageID;
    }

    protected function AssignValues($row) {
        $valueObject = ActivityFactory::CreateValueObject();
                
        $valueObject->setId($row[ActivityVO::$dbId]);
        $valueObject->setActivityName($row[ActivityVO::$dbActivityName]);
        $valueObject->setActivityDescription($row[ActivityVO::$dbActivityDescription]);
        $valueObject->setActivityCost($row[ActivityVO::$dbActivityCost]);
        $valueObject->setActivityCapacity($row[ActivityVO::$dbActivityCapacity]);
        $valueObject->setActivityImageLoc($row[ActivityVO::$dbActivityImageLoc]);
        $valueObject->setActivityPageID($row[ActivityVO::$dbActivityPageID]);
        
        return $valueObject;
    }
    
    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                ActivityVO::$dbId.",".
                ActivityVO::$dbActivityName.",".
                ActivityVO::$dbActivityDescription.",".
                ActivityVO::$dbActivityCost.",".
                ActivityVO::$dbActivityCapacity.",".
                ActivityVO::$dbActivityImageLoc.",".
                ActivityVO::$dbActivityPageID.
                ") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getActivityName())."','".
                $this->mysqli->real_escape_string($valueObject->getActivityDescription())."','".
                $this->mysqli->real_escape_string($valueObject->getActivityCost())."','".
                $this->mysqli->real_escape_string($valueObject->getActivityCapacity())."','".
                $this->mysqli->real_escape_string($valueObject->getActivityImageLoc())."','".
                $this->mysqli->real_escape_string($valueObject->getActivityPageID())."')"; 
        
        return $sql;
    }
    
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                /*ActivityVO::$dbId."='".
                $this->mysqli->real_escape_string($valueObject->getId())."',".*/
                ActivityVO::$dbActivityName."='".
                $this->mysqli->real_escape_string($valueObject->getActivityName())."',".
                ActivityVO::$dbActivityDescription."='".
                $this->mysqli->real_escape_string($valueObject->getActivityDescription())."',".
                ActivityVO::$dbActivityCost."='".
                $this->mysqli->real_escape_string($valueObject->getActivityCost())."',".
                ActivityVO::$dbActivityCapacity."='".
                $this->mysqli->real_escape_string($valueObject->getActivityCapacity())."',".
                ActivityVO::$dbActivityImageLoc."='".
                $this->mysqli->real_escape_string($valueObject->getActivityImageLoc())."',".
                ActivityVO::$dbActivityPageID."='".
                $this->mysqli->real_escape_string($valueObject->getActivityPageID())."' ".
                "WHERE ".AccountVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
}

?>
