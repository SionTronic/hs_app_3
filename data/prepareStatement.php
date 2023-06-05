<?php
function prepareStatement($table, $request_data, $con) {
global $con;   
    switch ($table) {
        case 'injury':
            $injury_name = mysqli_real_escape_string($con, $request_data['injury_name']);
            $weighting = intval($request_data['weighting']);
            
            if (checkIfItemExists($injury_name,'injury_name','injury', $con)) {
                // Update statement if injury allready existsts
                $sql = "UPDATE injury2 SET weighting_$weighting =  weighting_$weighting + 1 WHERE injury_name = ?";
            } else {
                // Insert statement
                $sql = "INSERT INTO injury2 (injury_name, weighting_$weighting) VALUES (?, 1)";
            }
            $stmt = mysqli_prepare($con, $sql);
     
            // Bind the values to the statement if necessary
                $injury_name = $request_data['injury_name'];
                $weighting = $request_data['weighting'];
                mysqli_stmt_bind_param($stmt, 's', $injury_name);
       
            // Execute the statement
            $result = mysqli_stmt_execute($stmt);
       
                if (!$result) {
                    http_response_code(500);
                    die(mysqli_error($con));
                }
       
           $insertId = mysqli_insert_id($con);
           echo json_encode(['id' => $insertId]);
            
            break;
        
        case 'mitigation':
            // Handle mitigation table statement
            $mitigation = mysqli_real_escape_string($con, $request_data['mitigation']);
            $weighting = intval($request_data['mitigated_severity']);
            
            if (checkIfItemExists( $mitigation,'mitigation', 'mitigation', $con)) {
                // Update statement if injury allready existsts
                $updateSql = "UPDATE mitigation SET weighting_$weighting =  weighting_$weighting + 1 WHERE mitigation = ?";
                return $updateSql;
            } else {
                // Insert statement
                $insertSql = "INSERT INTO mitigation (mitigation, weighting_$weighting) VALUES (?, 1)";
                return $insertSql;
            }
            break;
        
        case 'hazard':
            $hazard = mysqli_real_escape_string($con, $request_data['hazard']);

             // Insert statement if hazard does not exist
            if (!checkIfItemExists($hazard,'hazard','hazards', $con)) {
                echo "no ${hazard} in table!!!";
                $insertSql = "INSERT INTO hazards (hazard) VALUES (?)";
                return $insertSql;
            }
            break;
            case 'people_effected':
                $category = mysqli_real_escape_string($con, $request_data['category']);
    
                 // Insert statement if hazard does not exist
                if (!checkIfItemExists($category,'category','people_effected', $con)) {
                    echo "no ${category} in table!!!";
                    $insertSql = "INSERT INTO people_effected (category) VALUES (?)";
                    return $insertSql;
                }
                break;
            case 'injury_mitigation':
                $category = mysqli_real_escape_string($con, $request_data['category']);
    
                    // Insert statement if hazard does not exist
                if (!checkIfItemExists($category,'category','people_effected', $con)) {
                    echo "no ${category} in table!!!";
                    $insertSql = "INSERT INTO people_effected (category) VALUES (?)";
                    return $insertSql;
                }
                break;
            case 'recordAssessment':
                

                break;
        // Handle other tables
        
        default:
            // Handle default case
    }
}


?>
