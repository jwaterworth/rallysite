<?php

require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/OpenSessionFactory.inc.php");

/**
 * Description of OpenSessionDAO
 *
 * Database interaction logic for the open session value object
 *
 * @author James
 */
class OpenSessionDAO extends DatabaseAccessObject{
    
    public function __construct() {
        parent::__construct();
        $this->tableName = "openSession";
        $this->foreignKey = null;
    }
	
	/*
     * Deletes a value object from the database table specified by $valueObject parameter
     */
    public function DeleteByAccountId($accountId) {
        $affectedRows = 0;
        
		$sql = sprintf("DELETE FROM %s WHERE %s=%s", $this->tableName, OpenSessionVO::$dbAccountId, $accountId);			
		
		if(!$result = $this->mysqli->query($sql)) {		
			throw new Exception("There was an error running the delete query [" . $this->mysqli->error . "]");
		}
		
		$affectedRows = $this->mysqli->affected_rows;
		
        return $affectedRows;
    }
       
    protected function AssignValues($row) {
        $valueObject = OpenSessionFactory::CreateValueObject();
        
        $valueObject->setId($row[OpenSessionVO::$dbId]);
        $valueObject->setAccountId($row[OpenSessionVO::$dbAccountId]);
        $valueObject->setSessionId($row[OpenSessionVO::$dbSessionId]);
        $valueObject->setToken($row[OpenSessionVO::$dbToken]);
        
        return $valueObject;
    }

    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                OpenSessionVO::$dbId.",".
                OpenSessionVO::$dbAccountId.",".
				OpenSessionVO::$dbSessionId.",".				
                OpenSessionVO::$dbToken.") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getAccountId())."','".
				$this->mysqli->real_escape_string($valueObject->getSessionId())."','".
                $this->mysqli->real_escape_string($valueObject->getToken())."')"; 
				
        return $sql;
    }
	
	protected function GeneratePDOInsertSQL($valueObject) {
        //Init values
		$colSql = "";
		$valSql = "";
		$this->valueArray = array();
		
		if($valueObject->getAccountId()) { 
			$this->BuildInsertSql(OpenSessionVO::$dbAccountId, $valueObject->getAccountId(), $colSql, $valSql);
		}	

		if($valueObject->getSessionId()) { 
			$this->BuildInsertSql(OpenSessionVO::$dbSessionId, $valueObject->getSessionId(), $colSql, $valSql);
		}	

		if($valueObject->getToken()) { 
			$this->BuildInsertSql(OpenSessionVO::$dbToken, $valueObject->getToken(), $colSql, $valSql);
		}	
			
		$preparedSql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tableName, $colSql, $valSql);
		
        return $preparedSql;
    }

    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".                
                OpenSessionVO::$dbAccountId."='".
                $this->mysqli->real_escape_string($valueObject->getAccountId())."',".
                OpenSessionVO::$dbSessionId."='".
                $this->mysqli->real_escape_string($valueObject->getSessionId())."',".
				OpenSessionVO::$dbToken."='".
                $this->mysqli->real_escape_string($valueObject->getToken())."'".
                "WHERE ".OpenSessionVO::$dbId."=".
                $this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
	
	protected function GeneratePDOUpdateSQL($valueObject) {	
		//Init values
		$sql = "";
		$this->valueArray = array();
				
		if($valueObject->getAccountId()) { 
			$this->BuildUpdateSql(OpenSessionVO::$dbAccountId, $valueObject->getAccountId(), $sql);
		}
		
		if($valueObject->getSessionId() !== null) { 
			$this->BuildUpdateSql(OpenSessionVO::$dbSessionId, $valueObject->getSessionId(), $sql);
		}
		
		if($valueObject->getToken() !== null) { 
			$this->BuildUpdateSql(OpenSessionVO::$dbToken, $valueObject->getToken(), $sql);
		}
				
		$whereClauseSql = "";
		$this->AppendToWhereClause(OpenSessionVO::$dbId, $valueObject->getId(), $whereClauseSql, $this->valueArray);
		
		$preparedSql = sprintf("Update %s SET %s WHERE %s", $this->tableName, $sql, $whereClauseSql);
		
        return $preparedSql;
    }
}

?>
