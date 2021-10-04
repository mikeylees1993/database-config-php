<?php   
// http://localhost/CreateCOMP220DBandTable.php
// The authentication values are stored in auth.txt. 
// Submitted coursework must use the original settings: localhost, root, mysql, COMP220db, 3306
// The default password (line 3 of auth.txt) may be mysql or an empty string.  
// If this code does not run, your system is likely configured differently than the default installation.  
// If this is the case, change auth.txt to match your configuration. Reset before submitting.

// The code below erases all data and design from table name listed below.
$fh = fopen('auth.txt','r');
$Host =  trim(fgets($fh));
$UserName = trim(fgets($fh));
$Password = trim(fgets($fh));
$Database = trim(fgets($fh));
$Port = trim(fgets($fh));
$TableName = "220TestTable";
fclose($fh);
echo "<h1>Create COMP220db database and Testing table</h1>";
echo "<p>The purpose of this page is to verify your installation. Understanding this code will come later in the course.</p>";
$mysqlObj = new mysqli($Host, $UserName, $Password, "", $Port);
$stmt = $mysqlObj->prepare("create database if not exists $Database");
$dbCreated = $stmt->execute(); 	
if (!$dbCreated)
	echo $mysqlObj->connect_errno;
else
{
	// now that database is created, specify we are using the new database
	$mysqlObj = new mysqli($Host, $UserName, $Password, $Database, $Port);
	echo "<p>Database $Database is ready.</p>" ; 	
	$stmt = $mysqlObj->prepare("Drop table If Exists $TableName");
	$stmt->execute(); 	
	$field1 = "testfield1 varchar(100)";
	$field2 = "testfield2 decimal (4,1)";
	$SQLStatement = "Create Table $TableName($field1, $field2)";
	$stmt = $mysqlObj->prepare($SQLStatement);
	if ($stmt == false) echo "Prepare failed on query $SQLStatement";
	$CreateResult = $stmt->execute();
	if ($CreateResult) 
		echo "$TableName table created.";
	else
		echo "Cannot create table $TableName. Query $SQLStatement failed. " . $stmt->error;
}
$stmt->close();
$mysqlObj->close();
?>