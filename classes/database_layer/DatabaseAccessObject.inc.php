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
     * Optional foreign key for table
     */
    protected $foreignKey;
    
    /*
     * Constructor
     * 
     * Sets up connection to database
     */
    public function __construct() {
        //$this->connect = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
		
        //$this->db = mysql_select_db(DB_NAME);
		
		$this->mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		
		if($this->mysqli->connect_errno > 0) {
			throw new Exception("Unable to connect to database [" . $this->mysqli->connect_error . "]");
		}
    }
    
    /*
     * Executes an sql query specified by parameter $sql
     *
     * Returns an array of value objects returned from database query
     */
    protected function ExecuteQuery($sql) {
	
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
     * Get all records from database table specified in sub class constructor
     */
    public function GetAll() {
        $sql = sprintf("SELECT * FROM %s ORDER BY id ASC",$this->tableName);
        return $this->ExecuteQuery($sql);
    }
    
    /*
     * Get a particular record from database table, using it's primary key as an identifier
     */
    public function GetById($id) {
        $valueObjectArray = array();
        $sql = sprintf("SELECT * FROM %s WHERE id='%s' ORDER BY id ASC", $this->tableName, $id);
        $valueObjectArray = $this->ExecuteQuery($sql);
        return count($valueObjectArray) > 0 ? $valueObjectArray[0] : null;
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
    public function GetByForeignKey($param) {
        //Attempt to get records if foreign key is set
        if($this->foreignKey != null){
            $valueObjectArray = array();
            $sql = sprintf("SELECT * FROM %s WHERE %s = '%s' ORDER BY id ASC", $this->tableName, $this->foreignKey, $param);
            $valueObjectArray = $this->ExecuteQuery($sql);
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
    public function Save(IValueObject $valueObject) {
        $affectedRows = 0;
        $lastInsertID = 0;
		$currVO = array();
		
		$isUpdate = false;
        if($valueObject->getId() != "") {
            $currVO = $this->GetById($valueObject->getId());
        }
        
        //If entry exists update, otherwise insert new user
        if(sizeof($currVO) > 0) {
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
     * Deletes a value object from the database table specified by $valueObject parameter
     */
    public function Delete(IValueObject $valueObject) {
        $affectedRows = 0;
        
        //Check for user ID
        if($valueObject->getId() != "") {
            $currVO = $this->GetById($valueObject->getId());
        }
        
        //Delete row
        if(sizeof($currVO) > 0 ) {
            $sql = sprintf("DELETE FROM %s WHERE id=%s", $this->tableName, $valueObject->getId());
            //Old SQL
			//mysql_query($sql, $this->connect) or die(mysql_error());
			
			//New SQL
			if(!$result = $this->mysqli->query($sql)) {		
				throw new Exception("There was an error running the delete query [" . $this->mysqli->error . "]");
			}
			
            $affectedRows = $this->mysqli->affected_rows;
        }
        return $affectedRows;
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
