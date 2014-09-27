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
    
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                /*BookingVO::$dbId."='".
                $this->mysqli->real_escape_string($valueObject->getId())."',".*/
                BookingVO::$dbUserID."='".
                $this->mysqli->real_escape_string($valueObject->getUserID())."' ".
                $this->mysqli->real_escape_string($valueObject->getBookingFee())."' ".
                $this->mysqli->real_escape_string($valueObject->getPaid())."' ".
                "WHERE ".BookingInfoVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
}

?>
