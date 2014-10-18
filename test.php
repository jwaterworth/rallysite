<?php
//Database
define("DB_HOST", "omicron");
define("DB_NAME", "rallysite");
define("DB_USERNAME", "james");
define("DB_PASSWORD", "Bd82A4fp");



function BuildInsertSql($fieldName, $value, &$colSql, &$valSql, &$valueArray) {
		$temp = $colSql != "" ? "," : "";			
		$valName = ":" . $fieldName;
		$col = $temp . $fieldName;
		
		$colSql .= $col;
		$valSql .= $temp . $valName;
		$valueArray[$valName] = $value;
	}
	
function Create() {	
	$colSql = "";
	$valSql = "";
	$valueArray = array();

	BuildInsertSql("name", "value1", $colSql, $valSql, $valueArray);
	BuildInsertSql("email", "value2", $colSql, $valSql, $valueArray);
	BuildInsertSql("phoneNumber", "value3", $colSql, $valSql, $valueArray);
	BuildInsertSql("emergName", "value4", $colSql, $valSql, $valueArray);

	$sql = "INSERT INTO account (" . $colSql .") VALUES (". $valSql .")";
	//echo $sql;
	return $sql;
	foreach($valueArray as $val) {
		//echo $val . ",";
	}


	 new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$conn = new PDO("mysql:host=".DB_HOST .";dbname=". DB_NAME,DB_USERNAME,DB_PASSWORD);

	$q = $conn->prepare($sql);
	$q->execute($valueArray);
}

function BuildUpdateSql($fieldName, $value, &$sql, &$valueArray ) {
	$prefix = $sql != "" ? "," : "";
	$valName = ":" . $fieldName;
	$sql .= sprintf("%s %s = %s", $prefix, $fieldName, $valName);
	
	$valueArray[$valName] = $value;
}

function AppendToWhereClause($fieldName, $value, &$whereClauseSql, &$valueArray, $grouping = "AND") {
	$prefix = $whereClauseSql != "" ? " " . $grouping : "";
	$valName = ":" . $fieldName;
	
	$whereClauseSql .= sprintf("%s %s = %s", $prefix, $fieldName, $valName);
	$valueArray[$valName] = $value;
}

function Update() {
	$sql = "";
	$whereClauseSql = "";
	$valueArray = array();

	BuildUpdateSql("name", "wadwwdawf", $sql, $valueArray);
	BuildUpdateSql("email", "value2", $sql, $valueArray);
	BuildUpdateSql("phoneNumber", "value3", $sql, $valueArray);
	BuildUpdateSql("emergName", "value4", $sql, $valueArray);
	BuildUpdateSql("dateOfBirth", "1990-05-13", $sql, $valueArray);
	
	AppendToWhereClause("id", "35", $whereClauseSql, $valueArray);

	$sql = "Update account SET " . $sql ." WHERE ". $whereClauseSql;
	echo $sql;
	
	new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$conn = new PDO("mysql:host=".DB_HOST .";dbname=". DB_NAME,DB_USERNAME,DB_PASSWORD);
	
	$q = $conn->prepare($sql);	
	$q->execute($valueArray);
	echo $q->rowCount();
	
}

Update();
?>