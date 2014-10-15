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
        $this->tableName = 'BookingActivity';
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
    
	/*
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                BookingActivityVO::$dbBookingID."='".
                $this->mysqli->real_escape_string($valueObject->getBookingID())."',".
                BookingActivityVO::$dbActivityID."='".
                $this->mysqli->real_escape_string($valueObject->getActivityID())."',".
                BookingActivityVO::$dbPriority."='".
                $this->mysqli->real_escape_string($valueObject->getPriority())."' ".
                "WHERE ".BookingInfoVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
	*/
	
	protected function GenerateUpdateSQL($valueObject) {
		$colSet = false;
	
        $sql = "UPDATE ".$this->tableName." SET ";
		
		if($valueObject->getBookingID()) { 
			$sql = $sql . $this->AppendSql(BookingActivityVO::$dbUserID, $valueObject->getBookingID(), $colSet);
			$colSet = true;
		}
		
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
	
	private function AppendSql($fieldName, $value, $colSet) {
		$temp = $colSet ? "," : "";			
		$temp = $temp . $fieldName ."='". $this->mysqli->real_escape_string($value) . "'";
		$colSet = true;
		
		return $temp;
	}
}

?>
