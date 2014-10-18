<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/BookingInfoFactory.inc.php");

/**
 * Description of BookingInfoDAO
 *
 * @author James
 */
class BookingInfoDAO extends DatabaseAccessObject{
    
    public function __construct() {
        parent::__construct();
        $this->tableName = 'BookingInfo';
        $this->foreignKey = null;
    }
    
    protected function AssignValues($row) {
        $valueObject = BookingInfoFactory::CreateValueObject();
        
        $valueObject->setId($row[BookingInfoVO::$dbId]);
        $valueObject->setBookingSummary($row[BookingInfoVO::$dbBookingSummary]);
        $valueObject->setBookingInfo($row[BookingInfoVO::$dbBookingInfo]);
        //$valueObject->setPaymentAddress($row[BookingInfoVO::$dbPaymentAddress]);
        //$valueObject->setPaymentMemberID($row[BookingInfoVO::$dbPaymentMemberID]);
        
        return $valueObject;
    }
    
    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                BookingInfoVO::$dbId.",".
                BookingInfoVO::$dbBookingSummary.",".
                BookingInfoVO::$dbPaymentAddress.",".
                //BookingInfoVO::$dbPaymentMemberID.",".
                BookingInfoVO::$dbBookingInfo.
				") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getBookingSummary())."','".
                $this->mysqli->real_escape_string($valueObject->getPaymentAddress())."','".
                //$this->mysqli->real_escape_string($valueObject->getPaymentMemberID())."','".
                $this->mysqli->real_escape_string($valueObject->getBookingInfo())
				."')"; 
        
        return $sql;
    }
	
	protected function GeneratePDOInsertSQL($valueObject) {
        //Init values
		$colSql = "";
		$valSql = "";
		$this->valueArray = array();
		
		if($valueObject->getBookingSummary()) { 
			$this->BuildInsertSql(BookingInfoVO::$dbBookingSummary, $valueObject->getBookingSummary(), $colSql, $valSql);
		}	

		if($valueObject->getPaymentAddress()) { 
			$this->BuildInsertSql(BookingInfoVO::$dbPaymentAddress, $valueObject->getPaymentAddress(), $colSql, $valSql);
		}	

		if($valueObject->getBookingInfo()) { 
			$this->BuildInsertSql(BookingInfoVO::$dbBookingInfo, $valueObject->getBookingInfo(), $colSql, $valSql);
		}		
			
		$preparedSql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tableName, $colSql, $valSql);
		
        return $preparedSql;
    }
    
    protected function GenerateUpdateSQL($valueObject) {
		
        $sql = "UPDATE ".$this->tableName." SET ".
                /*BookingInfoVO::$dbId."='".
                $this->mysqli->real_escape_string($valueObject->getId())."',".*/
                BookingInfoVO::$dbBookingSummary."='".
                $this->mysqli->real_escape_string($valueObject->getBookingSummary())."',".
                BookingInfoVO::$dbPaymentAddress."='".
                $this->mysqli->real_escape_string($valueObject->getPaymentAddress())."',".
                //BookingInfoVO::$dbPaymentMemberID."='".
                //$this->mysqli->real_escape_string($valueObject->getPaymentMemberID())."',".                
                BookingInfoVO::$dbBookingInfo."='".
                $this->mysqli->real_escape_string($valueObject->getBookingInfo())."' ".
                "WHERE ".BookingInfoVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
	
	protected function GeneratePDOUpdateSQL($valueObject) {	
		//Init values
		$sql = "";
		$this->valueArray = array();
				
		if($valueObject->getBookingSummary()) { 
			$this->BuildUpdateSql(BookingInfoVO::$dbBookingSummary, $valueObject->getBookingSummary(), $sql);
		}
		
		if($valueObject->getPaymentAddress() !== null) { 
			$this->BuildUpdateSql(BookingInfoVO::$dbPaymentAddress, $valueObject->getPaymentAddress(), $sql);
		}
		
		if($valueObject->getBookingInfo() !== null) { 
			$this->BuildUpdateSql(BookingInfoVO::$dbBookingInfo, $valueObject->getBookingInfo(), $sql);
		}
				
		$whereClauseSql = "";
		$this->AppendToWhereClause(BookingInfoVO::$dbId, $valueObject->getId(), $whereClauseSql, $this->valueArray);
		
		$preparedSql = sprintf("Update %s SET %s WHERE %s", $this->tableName, $sql, $whereClauseSql);
		
        return $preparedSql;
    }
}

?>
