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
        $this->tableName = "ActivityPage";
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
    protected function GenerateUpdateSQL($valueObject) {
        $sql = "UPDATE ".$this->tableName." SET ".
                /*ActivityPageVO::$dbId."='".
                $this->mysqli->real_escape_string($valueObject->getId())."',".*/
                ActivityPageVO::$dbActivitiesBrief."='".
                $this->mysqli->real_escape_string($valueObject->getActivitiesBrief())."' ".
                "WHERE ".AccountVO::$dbId."=".$this->mysqli->real_escape_string($valueObject->getId());
        return $sql;
    }
}

?>
