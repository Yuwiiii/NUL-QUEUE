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

            // Query to get courses and their queue numbers
            $getcourseDataSql = "SELECT pc.program, pc.course, pc.full_name
                FROM program_chairs AS pc
                JOIN colleges AS c ON pc.program = c.acronym
                WHERE c.acronym = '$acronym'";

            $getcourseDataSqlresult = $conn->query($getcourseDataSql);
            $displayedCourses = [];
            $courseCount = 0;

            while ($row = $getcourseDataSqlresult->fetch_assoc()) {
                $course = $row["course"];
                $full_name = $row["full_name"];
                $getqueuenumerDataSql = "SELECT aq.queue_number
                    FROM academics_queue AS aq 
                    JOIN program_chairs AS pc ON aq.concern = pc.full_name 
                    WHERE aq.status = 1 AND pc.course = '$course'
                    LIMIT 1"; // Limit to fetch only one queue number

                $getqueuenumerDataSqlresult = $conn->query($getqueuenumerDataSql);

                // Check if there is a queue number with status 1 for this course
                if ($getqueuenumerDataSqlresult->num_rows > 0) {
                    $courseCount++;
                    echo "<div class='list-div";

                    // Check if it's the last list-div
                    if ($courseCount === $getcourseDataSqlresult->num_rows) {
                        echo " last-list-div";
                    }

                    echo "'>";
                    echo "<p><b>" . $course ." - ". $full_name .":</b></p>";

                    // Fetch the first queue number for the current course
                    $row = $getqueuenumerDataSqlresult->fetch_assoc();
                    $queue_number = $row['queue_number'];

                    echo "<div class='qn-div' data-queue-number='" . $queue_number . "'>";
                    echo "<p style='color: white; font-size: 30px;'><b>" . $queue_number . "</b></p>";
                    echo "</div>";

                    echo "</div>";

                    // Add the course to the array to mark it as displayed
                    $displayedCourses[] = $course;
                } else {
                    // If no queue numbers found for the course
                    echo "<div class='list-div'>";
                    echo "<p><b>" . $course . "<b></p>";
                    echo "</div>";
                }
            }

            // End of displaying courses for the current college
            echo "</div>";

            // Add the college to the array to mark it as displayed
            $displayedProgram[] = $acronym;
        }
    }
} else {
    echo "No colleges found";
}
?>