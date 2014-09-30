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
		$valueObject->setStartDate($this->SetDate($row[EventVO::$dbStartDate]));
		$valueObject->setEndDate($this->SetDate($row[EventVO::$dbEndDate]));
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
				EventVO::$dbStartDate.",".
				EventVO::$dbEndDate.",".
                EventVO::$dbActivityPageID.",".
                ") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getName())."','".
                $this->mysqli->real_escape_string($valueObject->getSummary())."','".
                $this->mysqli->real_escape_string($valueObject->getInformation())."','".
                $this->mysqli->real_escape_string($valueObject->getLogoLoc())."','".
                $this->mysqli->real_escape_string($valueObject->getBookingInfoID())."','".
				$this->mysqli->real_escape_string($this->GetDate($valueObject->getStartDate()))."','".
				$this->mysqli->real_escape_string($this->GetDate($valueObject->getEndDate()))."','".
                $this->mysqli->real_escape_string($valueObject->getActivityPageID())."')"; 
        
        return $sql;
    }

    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
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
					EventVO::$dbStartDate."='".
                    $this->mysqli->real_escape_string($this->GetDate($valueObject->getStartDate()))."',".
					EventVO::$dbEndDate."='".
                    $this->mysqli->real_escape_string($this->GetDate($valueObject->getEndDate()))."',".					
                    EventVO::$dbActivityPageID."='".
                    $this->mysqli->real_escape_string($valueObject->getActivityPageID())."' ".
                    "WHERE ".EventVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
	
	private function SetDate($rawDate) {
		$newDate = date('d/m/Y', strtotime($rawDate));
		return $newDate;
	}
	
	private function GetDate($date) {		
		$dateParsed = date_parse_from_format('d/m/Y', $date);
		
		return sprintf("%s-%02s-%02s", $dateParsed["year"], $dateParsed["month"], $dateParsed["day"]);
	}
}

?>
