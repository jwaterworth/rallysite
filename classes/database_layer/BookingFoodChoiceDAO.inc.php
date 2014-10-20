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
        $this->tableName = 'bookingFoodChoice';
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
	
	protected function GeneratePDOInsertSQL($valueObject) {
        //Init values
		$colSql = "";
		$valSql = "";
		$this->valueArray = array();
		
		if($valueObject->getBookingID()) { 
			$this->BuildInsertSql(BookingFoodChoiceVO::$dbBookingID, $valueObject->getBookingID(), $colSql, $valSql);
		}	

		if($valueObject->getFoodChoiceID()) { 
			$this->BuildInsertSql(BookingFoodChoiceVO::$dbFoodChoiceID, $valueObject->getFoodChoiceID(), $colSql, $valSql);
		}		
			
		$preparedSql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tableName, $colSql, $valSql);
		
        return $preparedSql;
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
	
	protected function GeneratePDOUpdateSQL($valueObject) {	
		//Init values
		$sql = "";
		$this->valueArray = array();
				
		if($valueObject->getBookingID()) { 
			$this->BuildUpdateSql(BookingFoodChoiceVO::$dbBookingID, $valueObject->getBookingID(), $sql);
		}
		
		if($valueObject->getFoodChoiceID() !== null) { 
			$this->BuildUpdateSql(BookingFoodChoiceVO::$dbFoodChoiceID, $valueObject->getFoodChoiceID(), $sql);
		}
				
		$whereClauseSql = "";
		$this->AppendToWhereClause(BookingFoodChoiceVO::$dbId, $valueObject->getId(), $whereClauseSql, $this->valueArray);
		
		$preparedSql = sprintf("Update %s SET %s WHERE %s", $this->tableName, $sql, $whereClauseSql);
		
        return $preparedSql;
    }
}

?>
