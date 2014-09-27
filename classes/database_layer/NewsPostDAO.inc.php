<?php
require_once(DBLAYER_PATH."/DatabaseAccessObject.inc.php");
require_once(DATA_FACTORY_PATH."/NewsPostFactory.inc.php");


/**
 * Description of NewsPostDAO
 *
 * @author James
 */
class NewsPostDAO extends DatabaseAccessObject {
    
    public function __construct() {
        parent::__construct();
        $this->tableName = "NewsPost"; 
        $this->foreignKey = NewsPostVO::$dbEventID;
        
    }
    
    protected function AssignValues($row) {     
        $valueObject = NewsPostFactory::CreateValueObject();
                
        $valueObject->setId($row[NewsPostVO::$dbId]);
        $valueObject->setNewsTitle($row[NewsPostVO::$dbNewsTitle]);
        $valueObject->setNewsBody($row[NewsPostVO::$dbNewsBody]);
        $valueObject->setNewsTimeStamp($row[NewsPostVO::$dbNewsTimeStamp]);
        $valueObject->setUserID($row[NewsPostVO::$dbUserID]);
        $valueObject->setEventID($row[NewsPostVO::$dbEventID]);
        
        return $valueObject;
    }
    
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                /*NewsPostVO::$dbId."='".
                $this->mysqli->real_escape_string($valueObject->getId())."',".*/
                NewsPostVO::$dbNewsTitle."='".
                $this->mysqli->real_escape_string($valueObject->getNewsTitle())."',".
                NewsPostVO::$dbNewsBody."='".
                $this->mysqli->real_escape_string($valueObject->getNewsBody())."',".
                NewsPostVO::$dbNewsTimeStamp."='".
                $this->mysqli->real_escape_string($valueObject->getNewsTimeStamp())."',".
                NewsPostVO::$dbUserID."='".
                $this->mysqli->real_escape_string($valueObject->getUserID())."',".
                NewsPostVO::$dbEventID."='".
                $this->mysqli->real_escape_string($valueObject->getEventID())."' ".
                "WHERE ".NewsPostVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
    
    protected function GenerateInsertSQL($valueObject){
        $sql = "INSERT INTO ".$this->tableName." (".
                NewsPostVO::$dbId.",".
                NewsPostVO::$dbNewsTitle.",".
                NewsPostVO::$dbNewsBody.",".
                NewsPostVO::$dbNewsTimeStamp.",".
                NewsPostVO::$dbUserID.",".
                NewsPostVO::$dbEventID.
                ") VALUES ('".
                $this->mysqli->real_escape_string($valueObject->getId())."','".
                $this->mysqli->real_escape_string($valueObject->getNewsTitle())."','".
                $this->mysqli->real_escape_string($valueObject->getNewsBody())."','".
                $this->mysqli->real_escape_string($valueObject->getNewsTimeStamp())."','".
                $this->mysqli->real_escape_string($valueObject->getUserID())."','".
                $this->mysqli->real_escape_string($valueObject->getEventID())."')";
        
        return $sql;
    }
}

?>
