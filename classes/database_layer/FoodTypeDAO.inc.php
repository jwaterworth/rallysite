<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/FoodTypeFactory.inc.php");

/**
 * Description of FoodTypeDAO
 *
 * @author Bernard
 */
class FoodTypeDAO extends DatabaseAccessObject {
    
    public function __construct() {
        parent::__construct();
        $this->tableName = 'foodType';
        $this->foreignKey = FoodTypeVO::$dbBookingInfoID;
    }

    
    protected function AssignValues($row) {
        $valueObject = FoodTypeFactory::CreateValueObject();
        
        $valueObject->setId($row[FoodTypeVO::$dbId]);
        $valueObject->setFoodTypeName($row[FoodTypeVO::$dbFoodTypeName]);
        $valueObject->setBookingInfoID($row[FoodTypeVO::$dbBookingInfoID]);
        
        return $valueObject;
    }
    
    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                FoodTypeVO::$dbId.",".
                FoodTypeVO::$dbFoodTypeName.",".
                FoodTypeVO::$dbBookingInfoID.") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getFoodTypeName())."','".
                $this->mysqli->real_escape_string($valueObject->getBookingInfoID())."')"; 
        
        return $sql;
    }
	
	protected function GeneratePDOInsertSQL($valueObject) {
        //Init values
		$colSql = "";
		$valSql = "";
		$this->valueArray = array();
		
		if($valueObject->getFoodTypeName()) { 
			$this->BuildInsertSql(FoodTypeVO::$dbFoodTypeName, $valueObject->getFoodTypeName(), $colSql, $valSql);
		}	

		if($valueObject->getBookingInfoID()) { 
			$this->BuildInsertSql(FoodTypeVO::$dbBookingInfoID, $valueObject->getBookingInfoID(), $colSql, $valSql);
		}	
			
		$preparedSql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tableName, $colSql, $valSql);
		
        return $preparedSql;
    }
    
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                /*FoodChoiceVO::$dbId."='".
                $this->mysqli->real_escape_string($valueObject->getId())."',".*/
                FoodTypeVO::$dbFoodTypeName."='".
                $this->mysqli->real_escape_string($valueObject->getFoodTypeName())."',".
                FoodTypeVO::$dbBookingInfoID."='".
                $this->mysqli->real_escape_string($valueObject->getBookingInfoID())."' ".
                "WHERE ".FoodTypeVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
	
	protected function GeneratePDOUpdateSQL($valueObject) {	
		//Init values
		$sql = "";
		$this->valueArray = array();
				
		if($valueObject->getFoodTypeName()) { 
			$this->BuildUpdateSql(FoodTypeVO::$dbName, $valueObject->getFoodTypeName(), $sql);
		}
		
		if($valueObject->getBookingInfoID() !== null) { 
			$this->BuildUpdateSql(FoodTypeVO::$dbNotes, $valueObject->getBookingInfoID(), $sql);
		}
				
		$whereClauseSql = "";
		$this->AppendToWhereClause(FoodTypeVO::$dbId, $valueObject->getId(), $whereClauseSql, $this->valueArray);
		
		$preparedSql = sprintf("Update %s SET %s WHERE %s", $this->tableName, $sql, $whereClauseSql);
		
        return $preparedSql;
    }
}

?>
