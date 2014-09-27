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
        $this->tableName = "OpenSession";
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
}

?>
