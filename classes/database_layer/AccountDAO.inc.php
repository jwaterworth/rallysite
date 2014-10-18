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
		if($row[AccountVO::$dbDateOfBirth]) {
			$valueObject->setDateOfBirth($this->setDate($row[AccountVO::$dbDateOfBirth]));
		}		
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
                $this->mysqli->real_escape_string($valueObject->getDateOfBirth() ? $this->GetDate($valueObject->getDateOfBirth()) : "")."','".
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
	
	protected function GeneratePDOInsertSQL($valueObject) {
        //Init values
		$colSql = "";
		$valSql = "";
		$this->valueArray = array();
		
		if($valueObject->getName()) { 
			$this->BuildInsertSql(AccountVO::$dbName, $valueObject->getName(), $colSql, $valSql);
		}
		
		
		if($valueObject->getPassword()) { 
			$this->BuildInsertSql(AccountVO::$dbPassword, $valueObject->getPassword(), $colSql, $valSql);
		}
				
		if($valueObject->getUserSalt()) { 
			$this->BuildInsertSql(AccountVO::$dbUserSalt, $valueObject->getUserSalt(), $colSql, $valSql);
		}
		
		if($valueObject->getDateOfBirth()) {	
			$this->BuildInsertSql(AccountVO::$dbDateOfBirth, $this->GetDate($valueObject->getDateOfBirth()), $colSql, $valSql);
		}
					
		if($valueObject->getEmail()) {		
			$this->BuildInsertSql(AccountVO::$dbEmail, $valueObject->getEmail(), $colSql, $valSql);
		}	
		
		if($valueObject->getPhoneNumber()) {		
			$this->BuildInsertSql(AccountVO::$dbPhoneNumber, $valueObject->getPhoneNumber(), $colSql, $valSql);
		}	
		
		if($valueObject->getAddress()) {		
			$this->BuildInsertSql(AccountVO::$dbAddress, $valueObject->getAddress(), $colSql, $valSql);
		}	
		
		if($valueObject->getEmergName()) {		
			$this->BuildInsertSql(AccountVO::$dbEmergName, $valueObject->getEmergName(), $colSql, $valSql);
		}		
		
		if($valueObject->getEmergPhone()) {		
			$this->BuildInsertSql(AccountVO::$dbEmergPhone, $valueObject->getEmergPhone(), $colSql, $valSql);
		}	
		
		if($valueObject->getEmergAddress()) {		
			$this->BuildInsertSql(AccountVO::$dbEmergAddress, $valueObject->getEmergAddress(), $colSql, $valSql);
		}	
		
		if($valueObject->getEmergRelationship()) {		
			$this->BuildInsertSql(AccountVO::$dbEmergRelationship, $valueObject->getEmergRelationship(), $colSql, $valSql);
		}	
		
		if($valueObject->getDietaryReq()) {		
			$this->BuildInsertSql(AccountVO::$dbDietaryReq, $valueObject->getDietaryReq(), $colSql, $valSql);
		}	
		
		if($valueObject->getMedicalConditions()) {		
			$this->BuildInsertSql(AccountVO::$dbMedicalConditions, $valueObject->getMedicalConditions(), $colSql, $valSql);
		}	
		
		if($valueObject->getClubId()) {		
			$this->BuildInsertSql(AccountVO::$dbClubID, $valueObject->getClubId(), $colSql, $valSql);
		}	
		
		if($valueObject->getAccountTypeID()) {		
			$this->BuildInsertSql(AccountVO::$dbAccountTypeID, $valueObject->getAccountTypeID(), $colSql, $valSql);
		}		
			
		$preparedSql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tableName, $colSql, $valSql);
		
        return $preparedSql;
    }
	
    protected function GenerateUpdateSQL($valueObject) {
		$colSet = false;
	
        $sql = "UPDATE ".$this->tableName." SET ";
		
		if($valueObject->getName()) { 
			$sql = $sql . $this->AppendSql(AccountVO::$dbName, $valueObject->getName(), $colSet);
			$colSet = true;
		}
		
		if($valueObject->getDateOfBirth()) {	
			$sql = $sql . $this->AppendSql(AccountVO::$dbDateOfBirth, $this->getDate($valueObject->getDate()), $colSet);
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
	
	protected function GeneratePDOUpdateSQL($valueObject) {	
		//Init values
		$sql = "";
		$this->valueArray = array();
		
		if($valueObject->getName()) { 
			$this->BuildUpdateSql(AccountVO::$dbName, $valueObject->getName(), $sql);
		}
		
		if($valueObject->getDateOfBirth()) {	
			$this->BuildUpdateSql(AccountVO::$dbDateOfBirth, $this->GetDate($valueObject->getDateOfBirth()), $sql);
		}
					
		if($valueObject->getEmail()) {		
			$this->BuildUpdateSql(AccountVO::$dbEmail, $valueObject->getEmail(), $sql);
		}	
		
		if($valueObject->getPhoneNumber()) {		
			$this->BuildUpdateSql(AccountVO::$dbPhoneNumber, $valueObject->getPhoneNumber(), $sql);
		}	
		
		if($valueObject->getAddress()) {		
			$this->BuildUpdateSql(AccountVO::$dbAddress, $valueObject->getAddress(), $sql);
		}	
		
		if($valueObject->getEmergName()) {		
			$this->BuildUpdateSql(AccountVO::$dbEmergName, $valueObject->getEmergName(), $sql);
		}		
		
		if($valueObject->getEmergPhone()) {		
			$this->BuildUpdateSql(AccountVO::$dbEmergPhone, $valueObject->getEmergPhone(), $sql);
		}	
		
		if($valueObject->getEmergAddress()) {		
			$this->BuildUpdateSql(AccountVO::$dbEmergAddress, $valueObject->getEmergAddress(), $sql);
		}	
		
		if($valueObject->getEmergRelationship()) {		
			$this->BuildUpdateSql(AccountVO::$dbEmergRelationship, $valueObject->getEmergRelationship(), $sql);
		}	
		
		if($valueObject->getDietaryReq()) {		
			$this->BuildUpdateSql(AccountVO::$dbDietaryReq, $valueObject->getDietaryReq(), $sql);
		}	
		
		if($valueObject->getMedicalConditions()) {		
			$this->BuildUpdateSql(AccountVO::$dbMedicalConditions, $valueObject->getMedicalConditions(), $sql);
		}	
		
		if($valueObject->getClubId()) {		
			$this->BuildUpdateSql(AccountVO::$dbClubID, $valueObject->getClubId(), $sql);
		}	
		
		if($valueObject->getAccountTypeID()) {		
			$this->BuildUpdateSql(AccountVO::$dbAccountTypeID, $valueObject->getAccountTypeID(), $sql);
		}		
		
		$whereClauseSql = "";
		$this->AppendToWhereClause(AccountVO::$dbId, $valueObject->getId(), $whereClauseSql, $this->valueArray);
		
		$preparedSql = sprintf("Update %s SET %s WHERE %s", $this->tableName, $sql, $whereClauseSql);
		
        return $preparedSql;
    }	
	
	private function AppendSql($fieldName, $value, $colSet) {
		$temp = $colSet ? "," : "";			
		$temp = $temp . $fieldName ."='". $this->mysqli->real_escape_string($value) . "'";
		$colSet = true;
		
		return $temp;
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
