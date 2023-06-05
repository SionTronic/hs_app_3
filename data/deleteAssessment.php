<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable mysqli error reporting


function handleDeleteAssessment($request_data, $con) {

        $customer_id = $request_data['jobID'];
        $assessment_id = $request_data['assessmentID'];
       
    
        // Start a transaction
        $con->begin_transaction();
    
        try {

    
            // Insert into the 'assessments_customerdata' table
            $customerHazardStmt = $con->prepare("DELETE FROM assessments_customerdata 
                                                 WHERE customer_id = ? AND assessment_id = ?");
                                                 
            $customerHazardStmt->bind_param('ii', $customer_id, $assessment_id);
           // echo $customerHazardStmt;
            $customerHazardStmt->execute();
    
    
            // Commit the transaction
            $con->commit();
    
            echo "Assessment delete successfully.";
        } catch (Exception $e) {
            // Rollback the transaction on error
            $con->rollback();
            echo "Error occurred: " . $e->getMessage();
        }
    
        $con->begin_transaction();
        //Set weighting averages
}