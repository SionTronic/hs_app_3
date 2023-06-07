<?php
require_once 'cors.php';

require_once 'db_connection.php';
require_once 'allowedTables.php';
require_once 'functions.php';
require_once 'recordAssessment.php';
require_once 'deleteAssessment.php';
require_once 'createNewJob.php';
require_once 'allocatedJobs.php';


header('Content-Type: application/json');



cors();

//--------------------------------DISPLAY ERRORS--------------------------------------------------
ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable mysqli error reporting
//-------------------------------------------------------------------------------------------------

//--------------------------------ACUIRE CONNECTION TO DATABASE------------------------------------
$con = mysqli_connect($host, $user, $password, $dbname);

$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

//-------------------------------------------------------------------------------------------------

//----------------------------------------GET------------------------------------------------------
switch ($method) {
    case 'GET':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;
        $hazard_id = isset($_GET['hazard_id']) ? $_GET['hazard_id'] : null;
        $table = isset($_GET['table']) ? $_GET['table'] : null;
        $name = isset($_GET['name']) ? $_GET['name'] : null;
        
        
        if (!in_array($table, $allowedTables)) {
            http_response_code(400);
            die('Invalid table specified');
        }
    //     switch ($table) {
    //         case 'allocatedJobs':
    //             handleAllocatedJobs($name, $con);
    //         break;
    //         default;
    //     }
       $sortColumn = getSortColumn($table); // Initialize the sort column variable

        // Construct the SQL query
        $sql = "SELECT * FROM $table";
        $whereClause = '';
         
         if ($id){
            $whereClause .=  " WHERE id=$id";
         }
         if ($customer_id){
            $whereClause .=  " WHERE customer_id=$customer_id";
         }
         if ($hazard_id){
            $whereClause .=  " WHERE hazard_id=$hazard_id";
         }
         if($name){
            $whereClause = " WHERE pM = '$name' OR engineer = '$name' OR technician = '$name'";
        }
        if($table !== "assessments_customerdata" || $table !== "assessments"){
             $whereClause .=  " ORDER BY $sortColumn ASC";
        }
       

         $sql .=$whereClause;

      
         
         
         
        //  . ($id ? " WHERE customer_id=$id" : '');// . " ORDER BY $sortColumn ASC";
         //echo $sql;
        $result = mysqli_query($con, $sql);
        
        if (!$result) {
            http_response_code(500);
            die(mysqli_error($con));
        }
        
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        
        echo json_encode($data);
        break;
//-------------------------------------------------------------------------------------------------


//----------------------------------------POST-----------------------------------------------------

case 'POST':
    $table = isset($_GET['table']) ? $_GET['table'] : null;

    // Check if the specified table is allowed
    if (!in_array($table, $allowedTables)) {
        http_response_code(400);
        die('Invalid table specified (Check allowedTables.php)');
    }

    // Get the raw JSON data from the request body
    $json_data = file_get_contents('php://input');
    $request_data = json_decode($json_data, true);

    // Call the appropriate function based on the data type
    switch ($table) {
        // case 'hazards':
        //     handleHazardData($request_data, $con);
        //     break;
        // case 'injury_mitigation':
        //     handleInjuryData($request_data, $con);
        //     upDateAverages($request_data, $con);
        //     break;
        // case 'mitigation':
        //     handleMitigationData($request_data, $con);
        //     break;
        // case 'people_effected':
        //     handlePeopleData($request_data, $con);
        //     break;
        case 'recordAssessment':
            handleRecordAssessment($request_data, $con);
            break;
        case'delete':
            handleDeleteAssessment($request_data,$con);
        break;
        case'createNewJob':
            handleCreateNewJob($request_data,$con);
        break;
        // case 'injury_mitigation':
        //      handleInjuryMitigation($request_data, $con);
        //     break;
        // Handle other data types
        default:
            // Handle default case
    }
    break;
}
