<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/BookingActivityFactory.inc.php");

/**
 * Description of BookingActivityDAO
 *
 * @author James
 */
class BookingActivityDAO extends DatabaseAccessObject{
    
    public function __construct() {
        parent::__construct();
        $this->tableName = 'bookingActivity';
        $this->foreignKey = null;
    }
    
    protected function AssignValues($row) {
        $valueObject = BookingActivityFactory::CreateValueObject();
        
        $valueObject->setId($row[BookingActivityVO::$dbId]);
        $valueObject->setBookingID($row[BookingActivityVO::$dbBookingID]);
        $valueObject->setActivityID($row[BookingActivityVO::$dbActivityID]);
        $valueObject->setPriority($row[BookingActivityVO::$dbPriority]);
        
        return $valueObject;
    }
    
    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                BookingActivityVO::$dbId.",".
                BookingActivityVO::$dbBookingID.",".
                BookingActivityVO::$dbActivityID.",".
                BookingActivityVO::$dbPriority.") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getBookingID())."','".
                $this->mysqli->real_escape_string($valueObject->getActivityID())."','".
                $this->mysqli->real_escape_string($valueObject->getPriority())."')"; 
        
        return $sql;
    }
	
	protected function GeneratePDOInsertSQL($valueObject) {
        //Init values
		$colSql = "";
		$valSql = "";
		$this->valueArray = array();
		
		if($valueObject->getBookingID()) { 
			$this->BuildInsertSql(BookingActivityVO::$dbBookingID, $valueObject->getBookingID(), $colSql, $valSql);
		}		

		if($valueObject->getActivityID()) { 
			$this->BuildInsertSql(BookingActivityVO::$dbActivityID, $valueObject->getActivityID(), $colSql, $valSql);
		}	

		if($valueObject->getPriority()) { 
			$this->BuildInsertSql(BookingActivityVO::$dbPriority, $valueObject->getPriority(), $colSql, $valSql);
		}		
			
		$preparedSql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tableName, $colSql, $valSql);
		
        return $preparedSql;
    }
	
	protected function GenerateUpdateSQL($valueObject) {
		$colSet = false;
	
        $sql = "UPDATE ".$this->tableName." SET ";
		
		if($valueObject->getActivityID()) {	
			$sql = $sql . $this->AppendSql(BookingActivityVO::$dbActivityID, $valueObject->getActivityID(), $colSet);
			$colSet = true;
		}
					
		if($valueObject->getPriority()) {		
			$sql = $sql . $this->AppendSql(BookingActivityVO::$dbPriority, $valueObject->getPriority(), $colSet);
			$colSet = true;
		}	
		
		$sql = $sql . "WHERE ".BookingActivityVO::$dbId."=". $this->mysqli->real_escape_string($valueObject->getId());
		
        return $sql;
	}
	
	protected function GeneratePDOUpdateSQL($valueObject) {	
		//Init values
		$sql = "";
		$this->valueArray = array();
				
		if($valueObject->getActivityID()) { 
			$this->BuildUpdateSql(BookingActivityVO::$dbActivityID, $valueObject->getActivityID(), $sql);
		}
		
		if($valueObject->getPriority()) { 
			$this->BuildUpdateSql(BookingActivityVO::$dbPriority, $valueObject->getPriority(), $sql);
		}
				
		$whereClauseSql = "";
		$this->AppendToWhereClause(BookingActivityVO::$dbId, $valueObject->getId(), $whereClauseSql, $this->valueArray);
		
		$preparedSql = sprintf("Update %s SET %s WHERE %s", $this->tableName, $sql, $whereClauseSql);
		
        return $preparedSql;
    }
	
	private function AppendSql($fieldName, $value, $colSet) {
		$temp = $colSet ? "," : "";			
		$temp = $temp . $fieldName ."='". $this->mysqli->real_escape_string($value) . "'";
		$colSet = true;
		
		return $temp;
	}
}

?>
