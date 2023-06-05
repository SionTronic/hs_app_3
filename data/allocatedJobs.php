<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable mysqli error reporting


function handleAllocatedJobs($name, $con) {
    // Prepare the SQL statement
    $sql = "SELECT * FROM customerdata WHERE (pM = ? OR engineer = ? OR technician = ?) AND jobStatus = 'Active'";
    
    $allocatedJobStmt = $con->prepare($sql);
    $allocatedJobStmt->bind_param('sss', $name, $name, $name);
    
    try {
        $allocatedJobStmt->execute();
        $result = $allocatedJobStmt->get_result();
        
        // Fetch the data from the result set
        $allocatedJobs = [];
        while ($row = $result->fetch_assoc()) {
            $allocatedJobs[] = $row;
        }
        
        // Close the statement
        $allocatedJobStmt->close();
        
        return $allocatedJobs;
    } catch (Exception $e) {
        throw $e;
    }
}
