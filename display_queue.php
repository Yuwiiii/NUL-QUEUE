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

            $getcourseDataSql = "SELECT pc.program, pc.course
                FROM program_chairs AS pc
                JOIN colleges AS c ON pc.program = c.acronym
                WHERE c.acronym = '$acronym'";
            $getcourseDataSqlresult = $conn->query($getcourseDataSql);
            $displayedCourses = [];
            $courseCount = 0;

            while ($row = $getcourseDataSqlresult->fetch_assoc()) {
                $course = $row["course"];

                if (!in_array($course, $displayedCourses)) {
                    $courseCount++;
                    echo "<div class='list-div";
                    
                    // Check if it's the last list-div
                    if ($courseCount === $getcourseDataSqlresult->num_rows) {
                        echo " last-list-div";
                    }

                    echo "'>";
                    echo "<p><b>" . $course . ":</b></p>";

                    $getqueuenumerDataSql = "SELECT aq.queue_number, pc.full_name, pc.course
                        FROM academics_queue AS aq 
                        JOIN program_chairs AS pc ON aq.concern = pc.full_name 
                        WHERE aq.status = 1 AND pc.course = '$course'";
                    $getqueuenumerDataSqlresult = $conn->query($getqueuenumerDataSql);

                    if ($getqueuenumerDataSqlresult->num_rows > 0) {
                        while ($row = $getqueuenumerDataSqlresult->fetch_assoc()) {
                            echo "<div class='qn-div'>";
                            echo "<p><b>" . $row['queue_number'] . "</b></p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Loading...</p>";
                    }

                    echo "</div>";

                    // Add the course to the array to mark it as displayed
                    $displayedCourses[] = $course;
                }
            }

            echo "</div>";

            // Add the college to the array to mark it as displayed
            $displayedProgram[] = $acronym;
        }
    }
} else {
    echo "No colleges found";
}
?>
