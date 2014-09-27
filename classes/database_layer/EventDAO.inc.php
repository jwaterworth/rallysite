<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/EventFactory.inc.php");

/**
 * Description of EventDAO
 *
 * @author James
 */
class EventDAO extends DatabaseAccessObject{
    
    public function __construct() {
        parent::__construct();
        $this->tableName = "Event";
        $this->foreignKey = null;
    }

    protected function AssignValues($row) {
        $valueObject = EventFactory::CreateValueObject();
                
        $valueObject->setId($row[EventVO::$dbId]);
        $valueObject->setName($row[EventVO::$dbName]);
        $valueObject->setSummary($row[EventVO::$dbSummary]);
        $valueObject->setInformation($row[EventVO::$dbInformation]);
        $valueObject->setLogoLoc($row[EventVO::$dbLogoLoc]);
        $valueObject->setBookingInfoID($row[EventVO::$dbBookingInfoID]);
        $valueObject->setActivityPageID($row[EventVO::$dbActivityPageID]);
        
        return $valueObject;
    }

    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                EventVO::$dbId.",".
                EventVO::$dbName.",".
                EventVO::$dbSummary.",".
                EventVO::$dbInformation.",".
                EventVO::$dbLogoLoc.",".
                EventVO::$dbBookingInfoID.",".
                EventVO::$dbActivityPageID.",".
                ") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getName())."','".
                $this->mysqli->real_escape_string($valueObject->getSummary())."','".
                $this->mysqli->real_escape_string($valueObject->getInformation())."','".
                $this->mysqli->real_escape_string($valueObject->getLogoLoc())."','".
                $this->mysqli->real_escape_string($valueObject->getBookingInfoID())."','".
                $this->mysqli->real_escape_string($valueObject->getActivityPageID())."')"; 
        
        return $sql;
    }

    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                    //EventVO::$dbId."='".
                    //$valueObject->getId()."',".
                    EventVO::$dbName."='".
                    $this->mysqli->real_escape_string($valueObject->getName())."',".
                    EventVO::$dbSummary."='".
                    $this->mysqli->real_escape_string($valueObject->getSummary())."',".
                    EventVO::$dbInformation."='".
                    $this->mysqli->real_escape_string($valueObject->getInformation())."',".
                    EventVO::$dbLogoLoc."='".
                    $this->mysqli->real_escape_string($valueObject->getLogoLoc())."',".
                    EventVO::$dbBookingInfoID."='".
                    $this->mysqli->real_escape_string($valueObject->getBookingInfoID())."',".
                    EventVO::$dbActivityPageID."='".
                    $this->mysqli->real_escape_string($valueObject->getActivityPageID())."' ".
                    "WHERE ".EventVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
}

?>
