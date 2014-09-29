<?php

require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/AccountFactory.inc.php");

/**
 * Description of AccountsDAO
 *
 * @author James
 */
class AccountDAO extends DatabaseAccessObject{
    
    public function __construct() {
        parent::__construct();
        $this->tableName = "Account";
        $this->foreignKey = null;
    }
	
	public function GetByEmail($email) {
		$valueObjectArray = array();
        $sql = sprintf("SELECT * FROM %s WHERE email='%s'", $this->tableName, $email);
        $valueObjectArray = $this->ExecuteQuery($sql);
		
        return count($valueObjectArray) > 0 ? $valueObjectArray[0] : null;
	}
       
    protected function AssignValues($row) {
        $valueObject = AccountFactory::CreateValueObject();
        
        $valueObject->setId($row[AccountVO::$dbId]);
        $valueObject->setName($row[AccountVO::$dbName]);
		$valueObject->setUserSalt($row[AccountVO::$dbUserSalt]);
		$valueObject->setPassword($row[AccountVO::$dbPassword]);
		$valueObject->setDateOfBirth($row[AccountVO::$dbDateOfBirth]);
        $valueObject->setEmail($row[AccountVO::$dbEmail]);
        $valueObject->setPhoneNumber($row[AccountVO::$dbPhoneNumber]);
        $valueObject->setAddress($row[AccountVO::$dbAddress]);
        $valueObject->setEmergName($row[AccountVO::$dbEmergName]);
        $valueObject->setEmergPhone($row[AccountVO::$dbEmergPhone]);
        $valueObject->setEmergAddress($row[AccountVO::$dbEmergAddress]);
		$valueObject->setEmergRelationship($row[AccountVO::$dbEmergRelationship]);
        $valueObject->setDietaryReq($row[AccountVO::$dbDietaryReq]);
        $valueObject->setMedicalConditions($row[AccountVO::$dbMedicalConditions]);
        $valueObject->setClubID($row[AccountVO::$dbClubID]);
        $valueObject->setAccountTypeID($row[AccountVO::$dbAccountTypeID]);
        
        return $valueObject;
    }

    protected function GenerateInsertSQL($valueObject) {
        $sql = "INSERT INTO ".$this->tableName." (".
                AccountVO::$dbId.",".
                AccountVO::$dbName.",".
				AccountVO::$dbPassword.",".
				AccountVO::$dbUserSalt.",".
                AccountVO::$dbDateOfBirth.",".
                AccountVO::$dbEmail.",".
                AccountVO::$dbPhoneNumber.",".
                AccountVO::$dbAddress.",".
                AccountVO::$dbEmergName.",".
                AccountVO::$dbEmergPhone.",".
                AccountVO::$dbEmergAddress.",".
				AccountVO::$dbEmergRelationship.",".
                AccountVO::$dbDietaryReq.",".
                AccountVO::$dbMedicalConditions.",".
                AccountVO::$dbClubID.",".
                AccountVO::$dbAccountTypeID.") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getName())."','".
				$this->mysqli->real_escape_string($valueObject->getPassword())."','".
				$this->mysqli->real_escape_string($valueObject->getUserSalt())."','".
                $this->mysqli->real_escape_string($valueObject->getDateOfBirth())."','".
                $this->mysqli->real_escape_string($valueObject->getEmail())."','".
                $this->mysqli->real_escape_string($valueObject->getPhoneNumber())."','".
                $this->mysqli->real_escape_string($valueObject->getAddress())."','".
                $this->mysqli->real_escape_string($valueObject->getEmergName())."','".
                $this->mysqli->real_escape_string($valueObject->getEmergPhone())."','".
                $this->mysqli->real_escape_string($valueObject->getEmergAddress())."','".
				$this->mysqli->real_escape_string($valueObject->getEmergRelationship())."','".
                $this->mysqli->real_escape_string($valueObject->getDietaryReq())."','".
                $this->mysqli->real_escape_string($valueObject->getMedicalConditions())."','".
                $this->mysqli->real_escape_string($valueObject->getClubID())."','".
                $this->mysqli->real_escape_string($valueObject->getAccountTypeID())."')"; 
				
        return $sql;
    }

    protected function GenerateUpdateSQL($valueObject) {
		$colSet = false;
	
        $sql = "UPDATE ".$this->tableName." SET ";
		
		if($valueObject->getName()) { 
			$sql = $sql . $this->AppendSql(AccountVO::$dbName, $valueObject->getName(), $colSet);
			$colSet = true;
		}
		
		if($valueObject->getDateOfBirth()) {			
			$sql = $sql . $this->AppendSql(AccountVO::$dbDateOfBirth, $valueObject->getDateOfBirth(), $colSet);
			$colSet = true;
		}
					
		if($valueObject->getEmail()) {		
			$sql = $sql . $this->AppendSql(AccountVO::$dbEmail, $valueObject->getEmail(), $colSet);
			$colSet = true;
		}	
		
		if($valueObject->getPhoneNumber()) {		
			$sql = $sql . $this->AppendSql(AccountVO::$dbPhoneNumber, $valueObject->getPhoneNumber(), $colSet);
			$colSet = true;
		}	
		
		if($valueObject->getAddress()) {		
			$sql = $sql . $this->AppendSql(AccountVO::$dbAddress, $valueObject->getAddress(), $colSet);
			$colSet = true;
		}	
		
		if($valueObject->getEmergName()) {		
			$sql = $sql . $this->AppendSql(AccountVO::$dbEmergName, $valueObject->getEmergName(), $colSet);
			$colSet = true;
		}		
		
		if($valueObject->getEmergPhone()) {		
			$sql = $sql . $this->AppendSql(AccountVO::$dbEmergPhone, $valueObject->getEmergPhone(), $colSet);
			$colSet = true;
		}	
		
		if($valueObject->getEmergAddress()) {		
			$sql = $sql . $this->AppendSql(AccountVO::$dbEmergAddress, $valueObject->getEmergAddress(), $colSet);
			$colSet = true;
		}	
		
		if($valueObject->getEmergRelationship()) {		
			$sql = $sql . $this->AppendSql(AccountVO::$dbEmergRelationship, $valueObject->getEmergRelationship(), $colSet);
			$colSet = true;
		}	
		
		if($valueObject->getDietaryReq()) {		
			$sql = $sql . $this->AppendSql(AccountVO::$dbDietaryReq, $valueObject->getDietaryReq(), $colSet);
			$colSet = true;
		}	
		
		if($valueObject->getMedicalConditions()) {		
			$sql = $sql . $this->AppendSql(AccountVO::$dbMedicalConditions, $valueObject->getMedicalConditions(), $colSet);
			$colSet = true;
		}	
		
		if($valueObject->getMedicalConditions()) {		
			$sql = $sql . $this->AppendSql(AccountVO::$dbMedicalConditions, $valueObject->getMedicalConditions(), $colSet);
			$colSet = true;
		}	
		
		if($valueObject->getAccountTypeID()) {		
			$sql = $sql . $this->AppendSql(AccountVO::$dbAccountTypeID, $valueObject->getAccountTypeID(), $colSet);
			$colSet = true;
		}		
		
		$sql = $sql . "WHERE ".AccountVO::$dbId."=". $this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
	
	private function AppendSql($fieldName, $value, $colSet) {
		$temp = $colSet ? "," : "";			
		$temp = $temp . $fieldName ."='". $this->mysqli->real_escape_string($value) . "'";
		$colSet = true;
		
		return $temp;
	}
	
}

?>
