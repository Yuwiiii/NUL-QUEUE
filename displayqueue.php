<?php
session_start();

if (!isset($_SESSION['officeSelected'])) {
    header("Location: selectdisplay.php");
    exit();
}

@include 'database.php';

// Retrieve the selected office from the session
$officeSelected = $_SESSION['officeSelected'];

// Modify the query based on the selected office
if ($officeSelected == 'all') {
    $sql = "SELECT DISTINCT officeName FROM offices";
} else {
    $sql = "SELECT DISTINCT officeName FROM offices WHERE officeName = '$officeSelected'";
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Queue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/displayqueue.css">
    <link href='http://fonts.googleapis.com/css?family=' rel='stylesheet' type='text/css'>
</head>

<body>
    <div class="main-container">

        <!-- PENDING OF THE QUEUE STARTS -->
        <div class="pending-container">
            <div class="pending-heading">
                <form class="heading-text" action="validate_selection.php" method="post" id="officeForm">
                    <select name="officeSelected" id="officeSelect" required>
                        <!-- Add an option for "All Offices" -->
                        <option value="all" <?php echo ($officeSelected == '*') ? 'selected' : ''; ?>>All Offices
                        </option>

                        <!-- Populate the dropdown with office names from the database -->
                        <?php
                        @include 'database.php';

                        $sql = "SELECT DISTINCT officeName FROM offices";
                        $resultdropdown = $conn->query($sql);

                        if ($resultdropdown->num_rows > 0) {
                            while ($row = $resultdropdown->fetch_assoc()) {
                                $selected = ($row["officeName"] == $officeSelected) ? 'selected' : '';
                                echo '<option value="' . $row["officeName"] . '" ' . $selected . '>' . $row["officeName"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </form>
            </div>
            <div class="pending-heading heading-container">
                <h1 class="heading-text">NUMBER</h1>
            </div>
            <div class="pending-queue queue" id="pendingQueue">
            </div>
        </div>
        <!-- PENDING OF THE QUEUE ENDS -->

        <!-- SERVING OF THE QUEUE STARTS -->
        <div class="serving-container">
            <!-- TOP CONTAINER STARTS (NOW SERVING & DATETIME) -->
            <header class="heading-datetime-container">
                <div class="heading-container-serving">
                    <h1 class="heading-text-serving">NOW SERVING</h1>
                    <div id="playButton"></div>
                </div>
                <div class="datetime-container">
                    <h3 id="date"></h3>
                    <h1 id="time"></h1>
                </div>
            </header>
            <!-- TOP CONTAINER ENDS (NOW SERVING & DATETIME) -->


            <!-- OFFICES WITH QUEUE STARTS -->
            <section class="offices-container" id="officesContainer">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $officeName = $row["officeName"];

                        // Fetch data from the 'display' table for the current office
                        $officeDataSql = "SELECT * FROM display WHERE officeName = '$officeName' ORDER BY id DESC LIMIT 2";
                        $officeDataResult = $conn->query($officeDataSql);

                        echo '<div class="' . $officeName . '-office-container office">';
                        echo '<div class="heading-container">';
                        echo '<h1 class="heading-text">' . $officeName . '</h1>';
                        echo '</div>';
                        // echo '<div class="' . $officeName . '-queue-container" id="' . $officeName . 'QueueContainer">';
                

                        // echo '<div class="' . $officeName . '-queue queue">'; // Open the queue div once
                        echo '<div class="' . $officeName . '-queue queue" id="' . $officeName . 'QueueContainer">';

                        echo '<h2 class="queue-text">' . $window . ': ' . $queueNumber . '</h2>';


                        echo '</div>'; // Close the queue div
                
                        // else {
                        //     // Display an empty queue container if no data is found for the current office
                        //     echo '<div class="' . $officeName . '-queue queue">';
                        //     echo '<h2 class="queue-text">-</h2>';
                        //     echo '</div>';
                        // }
                
                        //echo '</div>'; // Close queue container
                        echo '</div>'; // Close office container
                    }
                } else {
                    echo "0 results";
                }
                ?>
            </section>

            <!-- OFFICES WITH QUEUE ENDS -->
        </div>
        <!-- SERVING OF THE QUEUE ENDS -->

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        const audio = new Audio('../nul-queue/sound/queue_notification.mp3');
        document.getElementById('playButton').addEventListener('click', () => {
            audio.play();
        });

        let currentQueues = {};

        function fetchQueueData() {
            <?php
            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                $officeName = $row["officeName"];
                ?>
                $.ajax({
                    url: 'fetch_queues.php',
                    type: 'POST',
                    data: {
                        office: '<?php echo $officeName; ?>'
                    },
                    success: function (data) {
                        $('#<?php echo $officeName; ?>QueueContainer').html(data);
                        const newData = $('#<?php echo $officeName; ?>QueueContainer').children().first().text();

                        if (currentQueues['<?php echo $officeName; ?>'] !== undefined && currentQueues['<?php echo $officeName; ?>'] !== newData) {
                            console.log('Data changed for', '<?php echo $officeName; ?>');
                            console.log('Old data:', currentQueues['<?php echo $officeName; ?>']);
                            console.log('New data:', newData);

                            // Play sound
                            $("#playButton").click();
                        }

                        // Update currentQueues with new data
                        currentQueues['<?php echo $officeName; ?>'] = newData;

                    }
                });
            <?php } ?>
        }


        // Fetch queue data on page load
        fetchQueueData();

        setInterval(fetchQueueData, 3000);

        //FOR PENDING QUEUE
        function fetchPendingQueue() {
            $.ajax({
                url: 'fetch_pending_queue.php',
                type: 'GET',
                success: function (data) {
                    $('#pendingQueue').html(data);
                }
            });
        }

        // Fetch pending queue data on page load
        fetchPendingQueue();

        setInterval(fetchPendingQueue, 3000);

        // Automatically submit the form when an option is selected
        $(document).ready(function () {
            $('#officeSelect').change(function () {
                $('#officeForm').submit();
            });
        });
    </script>
    <script src="script/displayscript.js"></script>
</body>

</html>