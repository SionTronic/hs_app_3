<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable mysqli error reporting


function handleUpdateCustomerData($request_data, $con)
{
    // Check if the required data is present in the request
    $id = isset($request_data['id']) ? $request_data['id'] : null;
    $jobNumber = isset($request_data['jobNumber']) ? $request_data['jobNumber'] : null;
    $title = isset($request_data['title']) ? $request_data['title'] : null;
    $firstName = isset($request_data['firstName']) ? $request_data['firstName'] : null;
    $lastName = isset($request_data['lastName']) ? $request_data['lastName'] : null;
    $clientName = isset($request_data['clientName']) ? $request_data['clientName'] : null;
    $phone = isset($request_data['phone']) ? $request_data['phone'] : null;
    $email = isset($request_data['email']) ? $request_data['email'] : null;
    $street = isset($request_data['street']) ? $request_data['street'] : null;
    $city = isset($request_data['city']) ? $request_data['city'] : null;
    $postCode = isset($request_data['postCode']) ? $request_data['postCode'] : null;
    $clientAddress = isset($request_data['clientAddress']) ? $request_data['clientAddress'] : null;
    $jobName = isset($request_data['jobName']) ? $request_data['jobName'] : null;
    $contactDate = isset($request_data['contactDate']) ? $request_data['contactDate'] : null;
    $appointedDate = isset($request_data['appointedDate']) ? $request_data['appointedDate'] : null;
    $startDate = isset($request_data['startDate']) ? $request_data['startDate'] : null;
    $contractedEndDate = isset($request_data['contractedEndDate']) ? $request_data['contractedEndDate'] : null;
    $estimatedEndDate = isset($request_data['estimatedEndDate']) ? $request_data['estimatedEndDate'] : null;
    $actualEndDate = isset($request_data['actualEndDate']) ? $request_data['actualEndDate'] : null;
    $jobStatus = isset($request_data['jobStatus']) ? $request_data['jobStatus'] : null;
    $gridReference = isset($request_data['gridReference']) ? $request_data['gridReference'] : null;
    $easting = isset($request_data['easting']) ? $request_data['easting'] : null;
    $northing = isset($request_data['northing']) ? $request_data['northing'] : null;
    $latitude = isset($request_data['latitude']) ? $request_data['latitude'] : null;
    $longitude = isset($request_data['longitude']) ? $request_data['longitude'] : null;
    $description = isset($request_data['description']) ? $request_data['description'] : null;
    $accepted = isset($request_data['accepted']) ? $request_data['accepted'] : null;
    $deposit = isset($request_data['deposit']) ? $request_data['deposit'] : null;
    $paid = isset($request_data['paid']) ? $request_data['paid'] : null;
    $comments = isset($request_data['comments']) ? $request_data['comments'] : null;
    $pM = isset($request_data['pM']) ? $request_data['pM'] : null;
    $engineer = isset($request_data['engineer']) ? $request_data['engineer'] : null;
    $technician = isset($request_data['technician']) ? $request_data['technician'] : null;
    $pcntComplete = isset($request_data['pcntComplete']) ? $request_data['pcntComplete'] : null;
    $hSScore = isset($request_data['hSScore']) ? $request_data['hSScore'] : null;

    // Prepare the SQL statement
    $sql = "UPDATE customerdata SET jobNumber=?, title=?, firstName=?, lastName=?, clientName=?, phone=?, email=?, street=?, city=?, postCode=?, clientAddress=?, jobName=?, contactDate=?, appointedDate=?, startDate=?, contractedEndDate=?, estimatedEndDate=?, actualEndDate=?, jobStatus=?, gridReference=?, easting=?, northing=?, latitude=?, longitude=?, description=?, accepted=?, deposit=?, paid=?, comments=?, pM=?, engineer=?, technician=?, pcntComplete=?, hSScore=? WHERE id=?";
    $updateStmt = $con->prepare($sql);

    // Bind the parameters
    $updateStmt->bind_param('ssssssssssssssssssssssssssssssssssi', $jobNumber, $title, $firstName, $lastName, $clientName, $phone, $email, $street, $city, $postCode, $clientAddress, $jobName, $contactDate, $appointmentDate, $startDate, $contractedEndDate, $estimatedEndDate, $actualEndDate, $jobStatus, $gridReference, $easting, $northing, $latitude, $longitude, $description, $accepted, $deposit, $paid, $comments, $pM, $engineer, $technician, $pcntComplete, $hSScore, $id);
    // Start a transaction
    $con->begin_transaction();

    try {
        $updateStmt->execute();

        // Commit the transaction
        $con->commit();
        echo "Customer data updated successfully.";
        $updateStmt->close();
    } catch (Exception $e) {
        // Rollback the transaction if an error occurred
        $con->rollback();
        throw $e;
    }
}
?>