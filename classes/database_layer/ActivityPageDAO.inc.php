<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/ActivityPageFactory.inc.php");

/**
 * Description of ActivityPageDAO
 *
 * @author James
 */
class ActivityPageDAO extends DatabaseAccessObject{

    public function __construct() {
        parent::__construct();
        $this->tableName = "activityPage";
        $this->foreignKey = null;
    }
    
    protected function AssignValues($row) {
        $valueObject = ActivityPageFactory::CreateValueObject();
                
        $valueObject->setId($row[ActivityPageVO::$dbId]);
        $valueObject->setActivitiesBrief($row[ActivityPageVO::$dbActivitiesBrief]);
        
        return $valueObject;
    }
    
    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                ActivityPageVO::$dbId.",".
                ActivityPageVO::$dbActivitiesBrief.") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getActivitiesBrief())."')"; 
        
        return $sql;
    }
	
	protected function GeneratePDOInsertSQL($valueObject) {
        //Init values
		$colSql = "";
		$valSql = "";
		$this->valueArray = array();
		
		if($valueObject->getActivitiesBrief()) { 
			$this->BuildInsertSql(ActivityPageVO::$dbActivitiesBrief, $valueObject->getActivitiesBrief(), $colSql, $valSql);
		}			
			
		$preparedSql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tableName, $colSql, $valSql);
		
        return $preparedSql;
    }
	
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                /*ActivityPageVO::$dbId."='".
                $this->mysqli->real_escape_string($valueObject->getId())."',".*/
                ActivityPageVO::$dbActivitiesBrief."='".
                $this->mysqli->real_escape_string($valueObject->getActivitiesBrief())."' ".
                "WHERE ".AccountVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
	
	protected function GeneratePDOUpdateSQL($valueObject) {	
		//Init values
		$sql = "";
		$this->valueArray = array();
		
		if($valueObject->getActivitiesBrief()) { 
			$this->BuildUpdateSql(ActivityPageVO::$dbActivitiesBrief, $valueObject->getActivitiesBrief(), $sql);
		}
				
		$whereClauseSql = "";
		$this->AppendToWhereClause(ActivityPageVO::$dbId, $valueObject->getId(), $whereClauseSql, $this->valueArray);
		
		$preparedSql = sprintf("Update %s SET %s WHERE %s", $this->tableName, $sql, $whereClauseSql);
		
        return $preparedSql;
    }	
}

?>
