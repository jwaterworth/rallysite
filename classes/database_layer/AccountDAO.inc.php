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
        $sql = "UPDATE ".$this->tableName." SET ".                
                ($valueObject->getName() ? AccountVO::$dbName."='".
                $this->mysqli->real_escape_string($valueObject->getName())."'," : "") .
				
				($valueObject->getDateOfBirth() ?
					AccountVO::$dbDateOfBirth."='".
					$this->mysqli->real_escape_string($valueObject->getDateOfBirth())."'," : "" ).
				
				($valueObject->getEmail() ?
					AccountVO::$dbEmail."='".
					$this->mysqli->real_escape_string($valueObject->getEmail())."'," : "" ).
				
				($valueObject->getPhoneNumber() ?
					AccountVO::$dbPhoneNumber."='".
					$this->mysqli->real_escape_string($valueObject->getPhoneNumber())."'," : "" ).
				
				($valueObject->getAddress() ?
					AccountVO::$dbAddress."='".
					$this->mysqli->real_escape_string($valueObject->getAddress())."'," : "" ).
				
				($valueObject->getEmergName() ?
					AccountVO::$dbEmergName."='".
					$this->mysqli->real_escape_string($valueObject->getEmergName())."'," : "" ).
				
				($valueObject->getEmergPhone() ?
					AccountVO::$dbEmergPhone."='".
					$this->mysqli->real_escape_string($valueObject->getEmergPhone())."'," : "" ).
				
				($valueObject->getEmergAddress() ?
					AccountVO::$dbEmergAddress."='".
					$this->mysqli->real_escape_string($valueObject->getEmergAddress())."'," : "" ).
				
				($valueObject->getEmergRelationship() ?
					AccountVO::$dbEmergRelationship."='".
					$this->mysqli->real_escape_string($valueObject->getEmergRelationship())."'," : "" ).
				
				($valueObject->getDietaryReq() ?
					AccountVO::$dbDietaryReq."='".
					$this->mysqli->real_escape_string($valueObject->getDietaryReq())."'," : "" ).
				
				($valueObject->getMedicalConditions() ?
					AccountVO::$dbMedicalConditions."='".
					$this->mysqli->real_escape_string($valueObject->getMedicalConditions())."'," : "" ).
				
				($valueObject->getClubID() ?
					AccountVO::$dbClubID."='".
					$this->mysqli->real_escape_string($valueObject->getClubID())."'," : "" ).
				
				($valueObject->getName() ?
					AccountVO::$dbAccountTypeID."='".
					$this->mysqli->real_escape_string($valueObject->getAccountTypeID())."' " : "" ).
								
                "WHERE ".AccountVO::$dbId."=".
                $this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
}

?>
