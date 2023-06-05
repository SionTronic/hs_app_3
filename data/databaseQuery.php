<?php

require_once 'db_connection.php';

$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


$columnsQuery = "SELECT COLUMN_NAME
                 FROM INFORMATION_SCHEMA.COLUMNS
                 WHERE TABLE_NAME = 'customerdata'
                   AND COLUMN_NAME != 'id'";

$result = $con->query($columnsQuery);
$alterTableQuery = "CREATE TABLE new_customerdata ";
$columnDefinitions = array();

while ($row = $result->fetch_assoc()) {
    $columnName = $row['COLUMN_NAME'];
    $columnDefinitions[] = "ADD `$columnName` VARCHAR(255),"; // Add backticks around the column name
}

$alterTableQuery .= implode(", ", $columnDefinitions);

$con->query($alterTableQuery);
