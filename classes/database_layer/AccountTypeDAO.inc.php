<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/AccountTypeFactory.inc.php");

/**
 * Description of AccountTypeDAO
 *
 * @author James
 */
class AccountTypeDAO extends DatabaseAccessObject{
    
    public function __construct() {
        parent::__construct();
        $this->tableName = 'accountType';
        $this->foreignKey = 'accountTypeName';
    }

    
    protected function AssignValues($row) {
        $valueObject = AccountTypeFactory::CreateValueObject();
        
        $valueObject->setId($row[AccountTypeVO::$dbId]);
        $valueObject->setAccountTypeName($row[AccountTypeVO::$dbAccountTypeName]);
        
        return $valueObject;
    }
    
    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                AccountTypeVO::$dbAccountTypeName.") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getAccountTypeName())."')"; 

        return $sql;
    }
	
	protected function GeneratePDOInsertSQL($valueObject) {
        //Init values
		$colSql = "";
		$valSql = "";
		$this->valueArray = array();
		
		if($valueObject->getAccountTypeName()) { 
			$this->BuildInsertSql(AccountTypeVO::$dbAccountTypeName, $valueObject->getAccountTypeName(), $colSql, $valSql);
		}			
			
		$preparedSql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tableName, $colSql, $valSql);
		
        return $preparedSql;
    }
    
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                    AccountTypeVO::$dbAccountTypeName."='".
                    $this->mysqli->real_escape_string($valueObject->getAccountTypeName())."' ".
                    "WHERE ".AccountTypeVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
	
	protected function GeneratePDOUpdateSQL($valueObject) {	
		//Init values
		$sql = "";
		$this->valueArray = array();
		
		if($valueObject->getAccountTypeName()) { 
			$this->BuildUpdateSql(AccountTypeVO::$dbAccountTypeName, $valueObject->getAccountTypeName(), $sql);
		}
				
		$whereClauseSql = "";
		$this->AppendToWhereClause(AccountTypeVO::$dbId, $valueObject->getId(), $whereClauseSql, $this->valueArray);
		
		$preparedSql = sprintf("Update %s SET %s WHERE %s", $this->tableName, $sql, $whereClauseSql);
		
        return $preparedSql;
    }	
}

?>
