<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable mysqli error reporting


function handleCreateNewJob($request_data, $con) {
     //$jobNumber = $request_data['jobNumber'];
    // $title = $request_data['title'];
    // $firstName = $request_data['firstName'];
    // $lastName = $request_data['lastName'];
   //  $clientName = $request_data['clientName'];
     //$phone = $request_data['phone'];
     //$email = $request_data['email'];
    // $street = $request_data['street'];
    // $city = $request_data['city'];
    // $postcode = $request_data['postcode'];
    // $clientAddress = $request_data['clientAddress'];
    // $jobName = $request_data['jobName'];
    // $contactDate = $request_data['contactDate'];
    // $appointmentDate = $request_data['appointmentDate'];
    // $startDate = $request_data['startDate'];
    // $contractedEndDate = $request_data['contractedEndDate'];
    // $estimatedEndDate = $request_data['estimatedEndDate'];
    // $acctualEndDate = $request_data['acctualEndDate'];
    // $Status = $request_data['Status'];
    // $gridReference = $request_data['gridReference'];
    // $description = $request_data['description'];
    // $pM = $request_data['pM'];
    // $engineer = $request_data['engineer'];
    // $technician = $request_data['technician'];

    // Start a transaction
   
        // Insert into the 'assessments' table
        // $newJobStmt = $con->prepare("INSERT INTO customerdata (jobNumber, title, firstName, lastName, 
        // clientName, phone, email, street, city, postcode, clientAddress, jobName, contactDate, appointmentDate, 
        // startDate, contractedEndDate, estimatedEndDate, acctualEndDate, Status,
        //  gridReference, description, pM, engineer, technician);
        // VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        // $newJobStmt->bind_param('sssssssssssssssssssssss', 
        // $jobNumber, $title, $firstName, $lastName, $clientName, $phone, $email, $street, 
        // $city, $postcode, $clientAddress, $jobName, $contactDate, $appointmentDate, $startDate, 
        // $contractedEndDate, $estimatedEndDate, $acctualEndDate, $Status, $gridReference, 
        // $description, $pM, $engineer, $technician);

        // $params = array(&$jobNumber, &$title, &$firstName, &$lastName, &$clientName, &$phone, &$email, 
        // &$street, &$city, &$postcode, &$clientAddress, &$jobName, &$contactDate, &$appointmentDate, 
        // &$startDate, &$contractedEndDate, &$estimatedEndDate, &$acctualEndDate, &$Status, &$gridReference, 
        // &$description, &$pM, &$engineer, &$technician);
    
        // foreach ($params as &$param) {
        //     if (empty($param)) {
        //         $param = null;
        //     }
        // }
    $jobNumber = isset($request_data['jobNumber']) ? $request_data['jobNumber'] : null;
    $jobName = isset ($request_data['jobName']) ? $request_data['jobName'] : null;
    $clientAddress = isset ($request_data['clientAddress']) ? $request_data['clientAddress'] : null;
    $phone = isset ($request_data['phone']) ? $request_data['phone'] : null;
    $email = isset ($request_data['email']) ? $request_data['email'] : null;
    $description = isset($request_data['description']) ? $request_data['description'] : null;
    $pM = isset($request_data['pM']) ? $request_data['pM'] : null;
    $engineer = isset($request_data['engineer']) ? $request_data['engineer'] : null;
    $technician = isset($request_data['technician']) ? $request_data['technician'] : null;
    $jobStatus = "Active";

    // Prepare the SQL statement
    $sql = "INSERT INTO customerdata (jobNumber, jobName, clientAddress, phone, 
    email, description, pM, engineer, technician, jobStatus)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $newJobStmt = $con->prepare($sql);

    // Bind the parameters
    $newJobStmt->bind_param('ssssssssss', $jobNumber, $jobName, $clientAddress, $phone,
    $email, $description, $pM, $engineer, $technician, $jobStatus);

    // Start a transaction
    $con->begin_transaction();

        try {
        $newJobStmt->execute();
        $newJobId = $con->insert_id;

        // Commit the transaction
        $con->commit();
        echo "New job recorded successfully.";
        $newJobStmt->close();
        
    } catch (Exception $e) {
        // Rollback the transaction if an error occurred
        $con->rollback();
        throw $e;
    }
}






