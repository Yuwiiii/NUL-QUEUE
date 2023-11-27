<?php
// Include your database connection code here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "queuing_system";
$conn = new mysqli($servername, $username, $password, $dbname);

$getprogramDataSql = "SELECT acronym FROM colleges";
$getprogramDataSqlresult = $conn->query($getprogramDataSql);

$displayedProgram = [];

        if ($getprogramDataSqlresult->num_rows > 0) {
            while ($row = $getprogramDataSqlresult->fetch_assoc()) {
                $acronym = $row["acronym"];

                if (!in_array($acronym, $displayedProgram)) {
                    echo '<div class="' . $acronym . ' office">';
                    echo "<div class='header-title'>";
                    echo "<p>" . $acronym . "</p>";
                    echo "</div>";

                    // Start here

                    $getcourseDataSql = "SELECT pc.program, pc.course
                        FROM program_chairs AS pc
                        JOIN colleges AS c ON pc.program = c.acronym
                        WHERE c.acronym = '$acronym'";
                    $getcourseDataSqlresult = $conn->query($getcourseDataSql);
                    $displayedCourses = [];
                    $courseCount = 0;
                    $hasQueueNumbers = false; // Flag variable

                    // ...

        while ($row = $getcourseDataSqlresult->fetch_assoc()) {
            $course = $row["course"];
            $getqueuenumerDataSql = "SELECT aq.queue_number
                FROM academics_queue AS aq 
                JOIN program_chairs AS pc ON aq.concern = pc.full_name 
                WHERE aq.status = 1 AND pc.course = '$course'";
            $getqueuenumerDataSqlresult = $conn->query($getqueuenumerDataSql);

            // Check if there are queue numbers with status 1 for this course
            if ($getqueuenumerDataSqlresult->num_rows > 0) {
                $courseCount++;
                echo "<div class='list-div";
            
                // Check if it's the last list-div
                if ($courseCount === $getcourseDataSqlresult->num_rows) {
                    echo " last-list-div";
                }
            
                echo "'>";
                echo "<p><b>" . $course . ":</b></p>";
            
                $courseQueueNumbers = []; // Initialize an array to store previous queue numbers for each course

                while ($row = $getqueuenumerDataSqlresult->fetch_assoc()) {
                    $courseQueueNumbers[$course][] = $row['queue_number'];
                
                    echo "<div class='qn-div' data-queue-number='" . $row['queue_number'] . "'>";
                    echo "<p><b>" . $row['queue_number'] . "</b></p>";
                    echo "</div>";
                }
            
                echo "</div>";
            
                // Set the flag to true as there are queue numbers
                $hasQueueNumbers = true;
            
                // Add the course to the array to mark it as displayed
                $displayedCourses[] = $course;
            }
        }


            // Check the flag and display "else" condition if no queue numbers
            if (!$hasQueueNumbers) {
                echo "<div class='que-div'>";
                echo "<p>-</p>";
                echo "</div>";
            }

            // End here

            echo "</div>";

            // Add the college to the array to mark it as displayed
            $displayedProgram[] = $acronym;
        }
    }
} else {
    echo "No colleges found";
}
?>