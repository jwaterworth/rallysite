<?php

require_once(INTERFACE_PATH."/IDataAccessObject.interface.php");

/**
 * Description of DatabaseAccessObject
 *
 * @author James
 */
abstract class DatabaseAccessObject implements IDatabaseAccessObject {
    /*
     * Name of database table, set in sub class constructor
     */
    protected $tableName;
    
    /*
     * Connection to MySQL database
     */
    protected $connect;
    /*
     * Result of connection to database
     */
    protected $db;
    
	/*
	* MySQL Improved extension object
	*/
	protected $mysqli;
	
	/*
	* PDO connection object
	*/
	protected $pdoConnection;
	
    /*
     * Optional foreign key for table
     */
    protected $foreignKey;
	
	/*
     * Value array for bound
     */
	protected $valueArray;
    
    /*
     * Constructor
     * 
     * Sets up connection to database
     */
    public function __construct() {
        //$this->connect = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
		
        //$this->db = mysql_select_db(DB_NAME);
		
		//$this->mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		
		try {
			$this->pdoConnection = new PDO("mysql:host=".DB_HOST .";dbname=". DB_NAME,DB_USERNAME,DB_PASSWORD);	
		} catch(Exception $e) {
			throw new Exception("An error occurred connecting to the database");
		}		
		/*
		if($this->mysqli->connect_errno > 0) {
			throw new Exception("Unable to connect to database [" . $this->mysqli->connect_error . "]");
		}
		*/
    }
    
    /*
     * Executes an sql query specified by parameter $sql
     *
     * Returns an array of value objects returned from database query
     */
    protected function ExecuteMYSQLIQuery($sql) {
	
        $tempArray = array();
        $valueObjects = array();
		
		//Run the query
	    if($result = $this->mysqli->query($sql)) {		
			//loop through results
			$count = 0;
			while($row = $result->fetch_assoc()) {
				//Append to value objects array
				$valueObjects[$count++] = $this->AssignValues($row);
			}
		} else {
			throw new Exception("There was an error running the query [" . $this->mysqli->error . "]");
		}
		
        return $valueObjects;
    }
	
	/*
     * Executes an sql query specified by parameter $sql
     *
     * Returns an array of value objects returned from database query
     */
    protected function ExecuteQuery($sql, $useValueArray = false) {
	
        $tempArray = array();
        $valueObjects = array();
		
		try {
			$stmt = $this->pdoConnection->prepare($sql);		
		
			if($useValueArray) {
				$stmt->execute($this->valueArray);
			} else {
				$stmt->execute();
			}		
						
			$count = 0;
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			//Append to value objects array
			$valueObjects[$count++] = $this->AssignValues($row);
			}	
		} catch (PDOException $e) {
			throw new Exception("There was an error running the query");
		}				
		
        return $valueObjects;
    }
	    
    /*
     * Get all records from database table specified in sub class constructor
     */
    public function GetAll($orderByField, $ascending = true) {
        $sql = sprintf("SELECT * FROM %s ORDER BY %s %s",$this->tableName, $orderByField, $ascending ? "ASC" : "DESC");
		
        return $this->ExecuteQuery($sql);
    }
    
    /*
     * Get a particular record from database table, using it's primary key as an identifier
     */
    public function GetById($id) {
		
		//Init the binding value array
		$this->valueArray = array();
		
        $valueObjectArray = array();
        //$sql = sprintf("SELECT * FROM %s WHERE id='%s' ORDER BY id ASC", $this->tableName, $id);
        //$valueObjectArray = $this->ExecuteQuery($sql);
		try {
			$sql = sprintf("SELECT * FROM %s WHERE id=:id ORDER BY id ASC", $this->tableName);		
			$this->valueArray[":id"] = $id;
			$valueObjectArray = $this->ExecuteQuery($sql, true);
		} catch(Exception $e) {
			throw new Exception("AN error occurred retrieving data from the database");
		}	
		
        return count($valueObjectArray) > 0 ? $valueObjectArray[0] : null;
    }
	
	public function RecordExists($id) {
		//Init the binding value array
		$this->valueArray = array();
		
		$sql = sprintf("SELECT COUNT(*) FROM %s WHERE id=:id ORDER BY id ASC", $this->tableName);
		
		$this->valueArray[":id"] = $id;
		
		
		try {		
			$stmt = $this->pdoConnection->prepare($sql);
			$stmt->execute($this->valueArray);
			
			return $stmt->fetchColumn();
			
		} catch (PDOException $e) {
			return false;
		}		
	}
    
    public function GetByAttribute($attribute, $param) {
        $valueObjectArray = array();
        
        //Temporarily store table foreign key
        $tempForeignKey = $this->foreignKey;
        
        //Temporarily set foreign key to attribute
        $this->foreignKey = $attribute;
        
        //Call GetByForeignKey with param
        $valueObjectArray = $this->GetByForeignKey($param);
        
        //Set foreignKey back to table foreign key
        $this->foreignKey = $tempForeignKey;
        
        return $valueObjectArray;
    }
    
    /*
     * Gets a particular record from database table, using it's foreign key as an identifier (if set)
     */
    public function GetByForeignKey($param, $ascending = true) {
        //Attempt to get records if foreign key is set
        if($this->foreignKey != null){
            $valueObjectArray = array();
            //$sql = sprintf("SELECT * FROM %s WHERE %s = '%s' ORDER BY id ASC", $this->tableName, $this->foreignKey, $param);
            //$valueObjectArray = $this->ExecuteQuery($sql);
			
			$sql = sprintf("SELECT * FROM %s WHERE %s = :%s ORDER BY id %s", $this->tableName, $this->foreignKey, $this->foreignKey, $ascending ? "ASC" : "DESC");
			
			$this->valueArray = array();
			$this->valueArray[":" . $this->foreignKey] = $param;
			
			$valueObjectArray = $this->ExecuteQuery($sql, true);
			
        } else {
            $valueObjectArray = null;
        }
        return $valueObjectArray;
    }
    
    /*
     * Saves a value object specified by parameter $valueObject
     * 
     * Returns number of affected rows in table
     */
    public function SaveMySQLI(IValueObject $valueObject) {
        $affectedRows = 0;
        $lastInsertID = 0;
		$currVO = array();
		
		$isUpdate = false;
        
        //If entry exists update, otherwise insert new user
        if($valueObject->getId() != "" && $this->RecordExists($valueObject->getId())) {
            $sql = $this->GenerateUpdateSQL($valueObject);
			$isUpdate = true;	
        } else {
            $sql = $this->GenerateInsertSQL($valueObject);			
        }
		 //new SQL Code
		if(!$result = $this->mysqli->query($sql)) {		
			throw new Exception("There was an error running the save query [" . $this->mysqli->error . "]");
		}
		
		$lastInsertID = $isUpdate ? $valueObject->getId() : $this->mysqli->insert_id ;
         
         return $lastInsertID;
    }
	
	
	/*
     * Executes an PDO save or update statement
     */
	public function Save(IValueObject $valueObject) {
		$affectedRows = 0;
        $lastInsertID = 0;
		$currVO = array();
		
		try {
			$isUpdate = false;
			//If entry exists update, otherwise insert new user
			if($valueObject->getId() != "" && $this->RecordExists($valueObject->getId())) {
				$sql = $this->GeneratePDOUpdateSQL($valueObject);
				$isUpdate = true;	
			} else {
				$sql = $this->GeneratePDOInsertSQL($valueObject);			
			}
			
			$stmt = $this->pdoConnection->prepare($sql);	
			
			if(!$stmt->execute($this->valueArray)) {		
				throw new Exception("There was an error running the save query.");
			}
		
		} catch(Exception $e) {
			throw new Exception("There was an error running the save query.");
		}	
		
		$lastInsertID = $isUpdate ? $valueObject->getId() : $this->pdoConnection->lastInsertId();
         
         return $lastInsertID;
	}	
    
    /*
     * Deletes a value object from the database table specified by $valueObject parameter
     */
    public function Delete(IValueObject $valueObject) {
        $affectedRows = 0;
        
        //Check it exists
        if($valueObject->getId() != "") {
            $currVO = $this->GetById($valueObject->getId());
        }
        
		try {
			//Delete row
			if(sizeof($currVO) > 0 ) {			
				$sql = sprintf("DELETE FROM %s WHERE id=:id", $this->tableName);
				$this->valueArray = array();
				$this->valueArray[":id"] = $valueObject->getId();
				$stmt = $this->pdoConnection->prepare($sql);	
				
				if(!$stmt->execute($this->valueArray)) {		
					throw new Exception("There was an error running the delete query.");
				}	
				
				$affectedRows = $stmt->rowCount();
			}
		} catch(Exception $e) {
			throw new Exception("There was an error running the delete query.");
		}
        
        return $affectedRows;
    }
	
	function BuildInsertSql($fieldName, $value, &$colSql, &$valSql) {
		$temp = $colSql != "" ? "," : "";			
		$valName = ":" . $fieldName;
		$col = $temp . $fieldName;
		
		$colSql .= $col;
		$valSql .= $temp . $valName;
		$this->valueArray[$valName] = $value;
	}
	
	protected function BuildUpdateSql($fieldName, $value, &$sql) {
		$prefix = $sql != "" ? "," : "";
		$valName = ":" . $fieldName;
		$sql .= sprintf("%s %s = %s", $prefix, $fieldName, $valName);
		
		$this->valueArray[$valName] = $value;
	}

    protected function AppendToWhereClause($fieldName, $value, &$whereClauseSql, $grouping = "AND") {
		$prefix = $whereClauseSql != "" ? " " . $grouping : "";
		$valName = ":" . $fieldName;
		
		$whereClauseSql .= sprintf("%s %s = %s", $prefix, $fieldName, $valName);
		
		$this->valueArray[$valName] = $value;
	}
    
    /*
     * Abstract function called by ExecuteQuery for assiging values in $row variable
     * to value objects specific to the data access objects subclass
     */
    abstract protected function AssignValues($row);
    
    /*
     * Abstract function called by save 
     */
    abstract protected function GenerateUpdateSQL($valueObject);
    
    abstract protected function GenerateInsertSQL($valueObject);
}

?>
