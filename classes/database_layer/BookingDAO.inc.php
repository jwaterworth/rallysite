<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/BookingFactory.inc.php");

/**
 * Description of BookingDAO
 *
 * @author James
 */
class BookingDAO extends DatabaseAccessObject{
    
    public function __construct() {
        parent::__construct();
        $this->tableName = 'Booking';
        $this->foreignKey = 'userID';
    }
    
    protected function AssignValues($row) {
        $valueObject = BookingFactory::CreateValueObject();
		
        $valueObject->setId($row[BookingVO::$dbId]);
        $valueObject->setUserID($row[BookingVO::$dbUserID]);
        $valueObject->setBookingFee($row[BookingVO::$dbBookingFee]);
        $valueObject->setPaid($row[BookingVO::$dbPaid]);
        
        return $valueObject;
    }
    
    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                BookingVO::$dbId.",".
                BookingVO::$dbUserID.",".
                BookingVO::$dbBookingFee.",".
                BookingVO::$dbPaid.") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getUserID())."','".
                $this->mysqli->real_escape_string($valueObject->getBookingFee())."','".
                $this->mysqli->real_escape_string($valueObject->getPaid())."')"; 
        
        return $sql;
    }
    
	/*	
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                BookingVO::$dbUserID."='".
                $this->mysqli->real_escape_string($valueObject->getUserID())."' ".
                $this->mysqli->real_escape_string($valueObject->getBookingFee())."' ".
                $this->mysqli->real_escape_string($valueObject->getPaid())."' ".
                "WHERE ".BookingInfoVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
	*/
	
	protected function GenerateUpdateSQL($valueObject) {
		$colSet = false;
	
        $sql = "UPDATE ".$this->tableName." SET ";
		
		if($valueObject->getUserID()) { 
			$sql = $sql . $this->AppendSql(BookingVO::$dbUserID, $valueObject->getUserID(), $colSet);
			$colSet = true;
		}
		
		if($valueObject->getBookingFee()) {	
			$sql = $sql . $this->AppendSql(BookingVO::$dbBookingFee, $valueObject->getBookingFee(), $colSet);
			$colSet = true;
		}
		
		//This is a bool so have to check null
		if($valueObject->getPaid() !== null) {
			$sql = $sql . ($colSet ? "," : "") . BookingVO::$dbPaid ."='". $valueObject->getPaid() . "'";
			$colSet = true;
		}	
		
		$sql = $sql . "WHERE ".BookingVO::$dbId."=". $this->mysqli->real_escape_string($valueObject->getId());
		
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
