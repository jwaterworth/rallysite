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
        $this->tableName = "Club";
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
}

?>
