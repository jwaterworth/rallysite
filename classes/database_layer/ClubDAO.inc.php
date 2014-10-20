<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/ClubFactory.inc.php");

/**
 * Description of ClubDAO
 *
 * @author James
 */
class ClubDAO extends DatabaseAccessObject{
    
    public function __construct() {
        parent::__construct();
        $this->tableName = "club";
        $this->foreignKey = null;
    }
    
    protected function AssignValues($row) {
        $valueObject = ClubFactory::CreateValueObject();
                
        $valueObject->setId($row[ClubVO::$dbId]);
        $valueObject->setName($row[ClubVO::$dbName]);
        $valueObject->getLogoLoc($row[ClubVO::$dbLogoLoc]);
        
        return $valueObject;
    }

    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".ClubVO::$dbId.",".ClubVO::$dbName.",".ClubVO::$dbLogoLoc.") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getName())."','".
                $this->mysqli->real_escape_string($valueObject->getLogoLoc())."')"; 
        
        return $sql;
    }
	
	protected function GeneratePDOInsertSQL($valueObject) {
        //Init values
		$colSql = "";
		$valSql = "";
		$this->valueArray = array();
		
		if($valueObject->getName()) { 
			$this->BuildInsertSql(ClubVO::$dbName, $valueObject->getName(), $colSql, $valSql);
		}	

		if($valueObject->getLogoLoc()) { 
			$this->BuildInsertSql(ClubVO::$dbLogoLoc, $valueObject->getLogoLoc(), $colSql, $valSql);
		}	
			
		$preparedSql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tableName, $colSql, $valSql);
		
        return $preparedSql;
    }

    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                    /*ClubVO::$dbId."='".
                    $this->mysqli->real_escape_string($valueObject->getId())."',".*/
                    ClubVO::$dbName."='".
                    $this->mysqli->real_escape_string($valueObject->getName())."',".
                    ClubVO::$dbLogoLoc."='".
                    $this->mysqli->real_escape_string($valueObject->getLogoLoc())."' ".
                    "WHERE ".ClubVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        
        return $sql;
    }
	
	protected function GeneratePDOUpdateSQL($valueObject) {	
		//Init values
		$sql = "";
		$this->valueArray = array();
				
		if($valueObject->getName()) { 
			$this->BuildUpdateSql(ClubVO::$dbName, $valueObject->getName(), $sql);
		}
		
		if($valueObject->getLogoLoc() !== null) { 
			$this->BuildUpdateSql(ClubVO::$dbLogoLoc, $valueObject->getLogoLoc(), $sql);
		}
				
		$whereClauseSql = "";
		$this->AppendToWhereClause(ClubVO::$dbId, $valueObject->getId(), $whereClauseSql, $this->valueArray);
		
		$preparedSql = sprintf("Update %s SET %s WHERE %s", $this->tableName, $sql, $whereClauseSql);
		
        return $preparedSql;
    }
}

?>
