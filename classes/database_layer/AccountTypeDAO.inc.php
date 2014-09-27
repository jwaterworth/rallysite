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
        $this->tableName = 'AccountType';
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
                AccountTypeVO::$dbId.",".
                AccountTypeVO::$dbAccountTypeName.") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getAccountTypeName())."')"; 

        return $sql;
    }
    
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                    /*AccountTypeVO::$dbId."='".
                    $this->mysqli->real_escape_string($valueObject->getId())."',".*/
                    AccountTypeVO::$dbAccountTypeName."='".
                    $this->mysqli->real_escape_string($valueObject->getAccountTypeName())."' ".
                    "WHERE ".AccountTypeVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
}

?>
