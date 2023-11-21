<?php
include '../database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ID = $_POST['ID'];
    $updatedAcronym = strtoupper($_POST['acronym']);
    $updatedOfficeName = strtoupper($_POST['OfficeName']);
    $isOtherOffice = isset($_POST['otherOfficesUpdated']) ? 1 : 0; // 1 for "Other Offices", 0 for "Not Other Offices"

    // Validate input to check for spaces in updated office name and acronym
    if (strpos($updatedOfficeName, ' ') !== false || strpos($updatedAcronym, ' ') !== false) {
        echo "Office name and acronym should not contain spaces.";
        exit; // Stop further processing if there are spaces
    }

    // Get the current officeName from the database
    $getCurrentOfficeNameQuery = "SELECT officeName FROM offices WHERE ID = ?";
    
    $stmtCurrentOfficeName = mysqli_prepare($conn, $getCurrentOfficeNameQuery);
    mysqli_stmt_bind_param($stmtCurrentOfficeName, 'i', $ID);
    mysqli_stmt_execute($stmtCurrentOfficeName);
    mysqli_stmt_bind_result($stmtCurrentOfficeName, $currentOfficeName);
    mysqli_stmt_fetch($stmtCurrentOfficeName);
    mysqli_stmt_close($stmtCurrentOfficeName);

    // Append "_logs" to the original table name
    $logsTableName = $currentOfficeName . "_logs";

    // Perform the update for officeName and office in offices table using prepared statements
    $updateOfficeQuery = "UPDATE offices SET acronym = ?, officeName = ?, office = ? WHERE ID = ?";
    
    $stmtOffice = mysqli_prepare($conn, $updateOfficeQuery);
    mysqli_stmt_bind_param($stmtOffice, 'ssii', $updatedAcronym, $updatedOfficeName, $isOtherOffice, $ID);

    if (mysqli_stmt_execute($stmtOffice)) {
        // If officeName in offices table is updated successfully, update the corresponding table name
        $renameTableQuery = "RENAME TABLE `$currentOfficeName` TO `$updatedOfficeName`, `$logsTableName` TO `$updatedOfficeName" . "_logs`";

        // Check if the table exists before attempting to rename it
        $checkTableQuery = "SHOW TABLES LIKE '$currentOfficeName'";
        $result = mysqli_query($conn, $checkTableQuery);

        if (mysqli_num_rows($result) > 0) {
            // Table exists, proceed with the rename
            if (mysqli_multi_query($conn, $renameTableQuery)) {
                echo "Office details and table name updated successfully";
            } else {
                echo "Error updating table name: " . mysqli_error($conn);
            }
        } else {
            // Table doesn't exist, handle accordingly (e.g., display a message)
            echo "Error: The table '$currentOfficeName' does not exist.";
        }
    } else {
        echo "Error updating office: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmtOffice);
}

mysqli_close($conn);
<<<<<<< HEAD
?>
=======


?>
>>>>>>> 370c682425903fd586c09a59324ffca61c227b8b
