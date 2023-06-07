<?php


function getSortColumn($table)
{
    switch ($table) {
        case 'hazards':
            return 'hazard';
        case 'injury':
            return 'injury_name';
        case 'people_effected':
            return 'category';
        case 'mitigation':
            return 'mitigation';
        case 'customerdata':
            return 'jobNumber';
        case 'assessments':
            return 'id';
        case 'assessments_customerdata':
            return 'id';
        default:
            // Handle the default case or throw an exception if needed
            return null;
    }
}


function getColumnTypes($request_data, $con)
{
    $columnValues = [];
    $placeholders = [];
    $types = '';

    foreach ($request_data as $column => $value) {
        $columnValues[] = $value;
        $escapedColumn = mysqli_real_escape_string($con, $column);
        $placeholders[] = "?";
        
        // Determine the data type for the value
        switch ($column) {
            case 'weighting':
            case 'severity':
            case 'mitigatedRisk':
                $types .= "i"; // Integer type
                break;
            case 'residualRisk':
                $types .= "d"; // Decimal type
                break;
            default:
                $types .= "s"; // String type (default)
                break;
        }
    }
    
    return [
        'columnValues' => $columnValues,
        'placeholders' => $placeholders,
        'types' => $types
    ];
}

require_once 'db_connection.php';

function checkIfItemExists($item_name, $columnTitle, $table, $con) {
    echo "checkIfItemExists functions.php";
    $item_name = mysqli_real_escape_string($con, $item_name);

    $sql = "SELECT * FROM  $table WHERE $columnTitle = '$item_name'";
    echo $sql;
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die(mysqli_error($con));
    }

    return mysqli_num_rows($result) > 0;
}

function setAverages($item, $column, $con) {
    //echo "setAverages";
    $sql = "UPDATE injury SET weighting = ROUND((
        (weighting_1 * 1) + (weighting_2 * 2) + (weighting_3 * 3) + (weighting_4 * 4) + (weighting_5 * 5) +
        (weighting_6 * 6) + (weighting_7 * 7) + (weighting_8 * 8) + (weighting_9 * 9) + (weighting_10 * 10)
    ) / (
        SELECT SUM(weighting_1 + weighting_2 + weighting_3 + weighting_4 + weighting_5 + weighting_6 + weighting_7 + weighting_8 + weighting_9 + weighting_10)
        FROM injury
        WHERE $column = ?
    ), 0)
    WHERE $column = ?";
    
    return $sql;
}

?>