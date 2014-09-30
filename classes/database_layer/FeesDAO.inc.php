<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/FeesFactory.inc.php");

/**
 * Description of FeesDAO
 *
 * @author James
 */
class FeesDAO extends DatabaseAccessObject{
    
    public function __construct() {
        parent::__construct();
        $this->tableName = 'Fees';
        $this->foreignKey = 'bookingInfoID';
    }
    
    protected function AssignValues($row) {
        $valueObject = FeesFactory::CreateValueObject();
        
        $valueObject->setId($row[FeesVO::$dbId]);
        $valueObject->setFee($row[FeesVO::$dbFee]);
        $valueObject->setDeadline($this->SetDate($row[FeesVO::$dbDeadline]));
        $valueObject->setBookingInfoID($row[FeesVO::$dbBookingInfoID]);
        
        return $valueObject;
    }
    
    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                FeesVO::$dbId.",".
                FeesVO::$dbFee.",".
                FeesVO::$dbDeadline.",".
                FeesVO::$dbBookingInfoID.") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getFee())."','".
                $this->mysqli->real_escape_string($this->GetDate($valueObject->getDeadline()))."','".
                $this->mysqli->real_escape_string($valueObject->getFoodTypeID())."')"; 
        
        return $sql;
    }
    
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                //FeesVO::$dbId."='".$this->mysqli->real_escape_string($valueObject->getId())."',".
                FeesVO::$dbFee."='".
                $this->mysqli->real_escape_string($valueObject->getFee())."',".
                FeesVO::$dbDeadline."='".
                $this->mysqli->real_escape_string($this->GetDate($valueObject->getDeadline()))."',".
                FeesVO::$dbBookingInfoID."='".
                $this->mysqli->real_escape_string($valueObject->getFoodTypeID())."' ".
                "WHERE ".FeesVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
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
