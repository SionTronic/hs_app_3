<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable mysqli error reporting


function handleRecordAssessment($request_data, $con) {
    $customer_id = $request_data['jobID'];
    $hazard = $request_data['hazard'];
    $consequence = $request_data['consequence'];
    $severity = $request_data['severity'];
    $probability = $request_data['probability'];
    $risk = $request_data['risk'];
    $peopleEffected = $request_data['peopleEffected'];
    $mitigation = $request_data['mitigation'];
    $mitigatedSeverity = $request_data['mitigatedSeverity'];
    $residualRisk = $request_data['residualRisk'];
    $effectiveness = $request_data['effectiveness'];

    // Start a transaction
    $con->begin_transaction();

    try {
        // Insert into the 'assessments' table
        $assessmentStmt = $con->prepare("INSERT INTO assessments (hazard, consequence, severity, probability,
                                         risk, peopleEffected, mitigation, mitigatedSeverity, residualRisk, effectiveness)
                                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                         ON DUPLICATE KEY UPDATE hazard = hazard");
        $assessmentStmt->bind_param('ssiiissiid', $hazard, $consequence, $severity, $probability, $risk, $peopleEffected, $mitigation, $mitigatedSeverity, $residualRisk, $effectiveness);
        $assessmentStmt->execute();
        $assessmentId = $con->insert_id;

        // Insert into the 'hazards' table
        $hazardStmt = $con->prepare("INSERT INTO hazards (hazard, weighting_$severity)
                                     VALUES (?, 1)
                                     ON DUPLICATE KEY UPDATE weighting_$severity = weighting_$severity + 1");
        $hazardStmt->bind_param('s', $hazard);
        $hazardStmt->execute();
        $hazard_id = $con->insert_id;
        
        // Insert into the 'injury' table
        $injuryStmt = $con->prepare("INSERT INTO injury (injury_name, weighting_$severity)
                                     VALUES (?, 1)
                                     ON DUPLICATE KEY UPDATE weighting_$severity = weighting_$severity + 1");
        $injuryStmt->bind_param('s', $consequence);
        $injuryStmt->execute();
        $injuryId = $con->insert_id;

        // Insert into the 'mitigation' table
        $mitigationStmt = $con->prepare("INSERT INTO mitigation (mitigation, weighting_$mitigatedSeverity)
                                         VALUES (?, 1)
                                         ON DUPLICATE KEY UPDATE weighting_$mitigatedSeverity = weighting_$mitigatedSeverity + 1");
        $mitigationStmt->bind_param('s', $mitigation);
        $mitigationStmt->execute();
        $mitigationId = $con->insert_id;

        // Insert into the 'people_effected' table
        $peopleEffectedStmt = $con->prepare("INSERT INTO people_effected (category)
                                     VALUES (?)
                                     ON DUPLICATE KEY UPDATE category = category ");
        $peopleEffectedStmt->bind_param('s', $peopleEffected);
        $peopleEffectedStmt->execute();
        $peopleEffected_id = $con->insert_id;

        // Insert into the 'assessments_customerdata' table
        $customerHazardStmt = $con->prepare("INSERT INTO assessments_customerdata (customer_id, assessment_id)
                                             VALUES (?, ?)
                                             ON DUPLICATE KEY UPDATE assessment_id = assessment_id");
                                             
        $customerHazardStmt->bind_param('ii', $customer_id, $assessmentId);
       // echo $customerHazardStmt;
        $customerHazardStmt->execute();

        // Insert into the 'hazard_customerdata' table
        $customerHazardStmt = $con->prepare("INSERT INTO hazard_customerdata (hazard_id, customer_id)
                                             VALUES (?, ?)
                                             ON DUPLICATE KEY UPDATE hazard_id = hazard_id");
                                             
        $customerHazardStmt->bind_param('ii', $hazard_id, $customer_id);
       // echo $customerHazardStmt;
        $customerHazardStmt->execute();

        // Insert into the 'injury_mitigation' table
        $injuryMitigationStmt = $con->prepare("INSERT INTO injury_mitigation (injury_id, mitigation_id)
                                               VALUES (?, ?)");
        $injuryMitigationStmt->bind_param('ii', $injuryId,  $mitigationId);
        $injuryMitigationStmt->execute();
        $injuryMitigationId = $con->insert_id;

        // Insert into the 'hazard_injury' table
        $injuryHazardStmt = $con->prepare("INSERT INTO hazard_injury (hazard_id, injury_id)
                                           VALUES (?, ?)");
        $injuryHazardStmt->bind_param('ii', $hazard_id, $injuryId);
        $injuryHazardStmt->execute();

        // Commit the transaction
        $con->commit();

        echo "Assessment recorded successfully.";
    } catch (Exception $e) {
        // Rollback the transaction on error
        $con->rollback();
        echo "Error occurred: " . $e->getMessage();
    }

    $con->begin_transaction();
    //Set weighting averages

    try{
        $injuryStmt = $con->prepare("UPDATE injury SET weighting = ROUND((
            (weighting_1 * 1) + (weighting_2 * 2) + (weighting_3 * 3) + (weighting_4 * 4) + (weighting_5 * 5) +
            (weighting_6 * 6) + (weighting_7 * 7) + (weighting_8 * 8) + (weighting_9 * 9) + (weighting_10 * 10)
        ) / (
            SELECT SUM(weighting_1 + weighting_2 + weighting_3 + weighting_4 + weighting_5 + 
            weighting_6 + weighting_7 + weighting_8 + weighting_9 + weighting_10)
            FROM injury
            WHERE injury_name = ?
        ), 0)
        WHERE injury_name = ?");
        
        $injuryStmt->bind_param('ss', $consequence, $consequence);
        $injuryStmt->execute();

      

        $mitigationStmt = $con->prepare("UPDATE mitigation SET mitigated_severity = ROUND((
            (weighting_1 * 1) + (weighting_2 * 2) + (weighting_3 * 3) + (weighting_4 * 4) + (weighting_5 * 5) +
            (weighting_6 * 6) + (weighting_7 * 7) + (weighting_8 * 8) + (weighting_9 * 9) + (weighting_10 * 10)
        ) / (
            SELECT SUM(weighting_1 + weighting_2 + weighting_3 + weighting_4 + weighting_5 + 
            weighting_6 + weighting_7 + weighting_8 + weighting_9 + weighting_10)
            FROM mitigation
            WHERE mitigation = ?
        ), 0)
        WHERE mitigation = ?");
        
        $mitigationStmt->bind_param('ss', $mitigation, $mitigation);
        $mitigationStmt->execute();

        // Update the injury_mitigation table

        $updateInjuryMitigationStmt = $con->prepare("UPDATE injury_mitigation
            SET severity = (SELECT weighting FROM injury WHERE id = injury_mitigation.injury_id),
            mitigated_severity = (SELECT mitigated_severity FROM mitigation WHERE id = injury_mitigation.mitigation_id)
            WHERE id = ?");
        $updateInjuryMitigationStmt->bind_param('i',  $injuryMitigationId, );
        $updateInjuryMitigationStmt->execute();

  


        $con->commit();

        if ($injuryStmt->error) {
            echo "Error occurred: " . $injuryStmt->error;
        } else {
            echo "Executed injury weighting successfully.";
        }

        if ($mitigationStmt->error) {
            echo "Error occurred: " . $mitigationStmt->error;
        } else {
            echo "Executed mitigation weighting successfully.";
        }

        if ($updateInjuryMitigationStmt->error) {
            echo "Error occurred: " . $updateInjuryMitigationStmt->error;
        } else {
            echo "Updated injury_mitigation table successfully.";
        }

    } catch (Exception $e) {
        // Rollback the transaction on error
        $con->rollback();
        echo "Error occurred: " . $e->getMessage();
    }
    // Get the query and parameters for debugging

}
?>
