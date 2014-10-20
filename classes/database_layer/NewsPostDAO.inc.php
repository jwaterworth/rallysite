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
        $this->tableName = "newspost"; 
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
                $this->mysqli->real_escape_string($this->SetDate($valueObject->getNewsTimeStamp()))."','".
                $this->mysqli->real_escape_string($valueObject->getUserID())."','".
                $this->mysqli->real_escape_string($valueObject->getEventID())."')";
        
        return $sql;
    }	
	
	protected function GeneratePDOInsertSQL($valueObject) {
        //Init values
		$colSql = "";
		$valSql = "";
		$this->valueArray = array();
		
		if($valueObject->getNewsTitle()) { 
			$this->BuildInsertSql(NewsPostVO::$dbNewsTitle, $valueObject->getNewsTitle(), $colSql, $valSql);
		}	

		if($valueObject->getNewsBody()) { 
			$this->BuildInsertSql(NewsPostVO::$dbNewsBody, $valueObject->getNewsBody(), $colSql, $valSql);
		}	

		if($valueObject->getNewsTimeStamp()) { 
			$this->BuildInsertSql(NewsPostVO::$dbNewsTimeStamp, $this->GetDate($valueObject->getNewsTimeStamp()), $colSql, $valSql);
		}	

		if($valueObject->getUserID()) { 
			$this->BuildInsertSql(NewsPostVO::$dbUserID, $valueObject->getUserID(), $colSql, $valSql);
		}	

		if($valueObject->getEventID()) { 
			$this->BuildInsertSql(NewsPostVO::$dbEventID, $valueObject->getEventID(), $colSql, $valSql);
		}	
			
		$preparedSql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tableName, $colSql, $valSql);
		
        return $preparedSql;
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
	
	protected function GeneratePDOUpdateSQL($valueObject) {	
		//Init values
		$sql = "";
		$this->valueArray = array();
				
		if($valueObject->getNewsTitle()) { 
			$this->BuildUpdateSql(NewsPostVO::$dbNewsTitle, $valueObject->getNewsTitle(), $sql);
		}
		
		if($valueObject->getNewsBody() !== null) { 
			$this->BuildUpdateSql(NewsPostVO::$dbNewsBody, $valueObject->getNewsBody(), $sql);
		}
		
		if($valueObject->getNewsTimeStamp() !== null) { 
			$this->BuildUpdateSql(NewsPostVO::$dbNewsTimeStamp, $this->GetDate($valueObject->getNewsTimeStamp()), $sql);
		}
		
		if($valueObject->getUserID() !== null) { 
			$this->BuildUpdateSql(NewsPostVO::$dbUserID, $valueObject->getUserID(), $sql);
		}
		
		if($valueObject->getEventID() !== null) { 
			$this->BuildUpdateSql(NewsPostVO::$dbEventID, $valueObject->getEventID(), $sql);
		}
				
		$whereClauseSql = "";
		$this->AppendToWhereClause(NewsPostVO::$dbId, $valueObject->getId(), $whereClauseSql, $this->valueArray);
		
		$preparedSql = sprintf("Update %s SET %s WHERE %s", $this->tableName, $sql, $whereClauseSql);
		
        return $preparedSql;
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
