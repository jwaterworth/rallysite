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
	
	protected function GeneratePDOInsertSQL($valueObject) {
        //Init values
		$colSql = "";
		$valSql = "";
		$this->valueArray = array();
		
		if($valueObject->getName()) { 
			$this->BuildInsertSql(EventVO::$dbName, $valueObject->getName(), $colSql, $valSql);
		}	

		if($valueObject->getSummary()) { 
			$this->BuildInsertSql(EventVO::$dbSummary, $valueObject->getSummary(), $colSql, $valSql);
		}	

		if($valueObject->getInformation()) { 
			$this->BuildInsertSql(EventVO::$dbInformation, $valueObject->getInformation(), $colSql, $valSql);
		}	

		if($valueObject->getLogoLoc()) { 
			$this->BuildInsertSql(EventVO::$dbLogoLoc, $valueObject->getLogoLoc(), $colSql, $valSql);
		}		

		if($valueObject->getBookingInfoID()) { 
			$this->BuildInsertSql(EventVO::$dbBookingInfoID, $valueObject->getBookingInfoID(), $colSql, $valSql);
		}	

		if($valueObject->getStartDate()) { 
			$this->BuildInsertSql(EventVO::$dbStartDate, $this->GetDate($valueObject->getStartDate()), $colSql, $valSql);
		}	

		if($valueObject->getEndDate()) { 
			$this->BuildInsertSql(EventVO::$dbEndDate, $this->GetDate($valueObject->getEndDate()), $colSql, $valSql);
		}	

		if($valueObject->getActivityPageID()) { 
			$this->BuildInsertSql(EventVO::$dbActivityPageID, $valueObject->getActivityPageID(), $colSql, $valSql);
		}	
			
		$preparedSql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tableName, $colSql, $valSql);
		
        return $preparedSql;
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
	
	protected function GeneratePDOUpdateSQL($valueObject) {	
		//Init values
		$sql = "";
		$this->valueArray = array();
				
		if($valueObject->getName()) { 
			$this->BuildUpdateSql(EventVO::$dbName, $valueObject->getName(), $sql);
		}
		
		if($valueObject->getSummary() !== null) { 
			$this->BuildUpdateSql(EventVO::$dbSummary, $valueObject->getSummary(), $sql);
		}
		
		if($valueObject->getInformation() !== null) { 
			$this->BuildUpdateSql(EventVO::$dbInformation, $valueObject->getInformation(), $sql);
		}
		
		if($valueObject->getLogoLoc() !== null) { 
			$this->BuildUpdateSql(EventVO::$dbLogoLoc, $valueObject->getLogoLoc(), $sql);
		}
					
		if($valueObject->getBookingInfoID() !== null) { 
			$this->BuildUpdateSql(EventVO::$dbBookingInfoID, $valueObject->getBookingInfoID(), $sql);
		}
		
		if($valueObject->getLogoLoc() !== null) { 
			$this->BuildUpdateSql(EventVO::$dbStartDate, $this->GetDate($valueObject->getStartDate()), $sql);
		}
		
		if($valueObject->getLogoLoc() !== null) { 
			$this->BuildUpdateSql(EventVO::$dbEndDate, $this->GetDate($valueObject->getEndDate()), $sql);
		}
		
		if($valueObject->getActivityPageID() !== null) { 
			$this->BuildUpdateSql(EventVO::$dbActivityPageID, $valueObject->getActivityPageID(), $sql);
		}
			
		$whereClauseSql = "";
		$this->AppendToWhereClause(EventVO::$dbId, $valueObject->getId(), $whereClauseSql, $this->valueArray);
		
		$preparedSql = sprintf("Update %s SET %s WHERE %s", $this->tableName, $sql, $whereClauseSql);
		
        return $preparedSql;
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
