<?php
@include 'database.php';

$sql = "SELECT DISTINCT officeName FROM offices";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Queue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/displayqueue.css">
    <link href='http://fonts.googleapis.com/css?family=' rel='stylesheet' type='text/css'>
</head>

<body>
    <div class="main-container">

        <!-- PENDING OF THE QUEUE STARTS -->
        <div class="pending-container">
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

                        if ($officeDataResult->num_rows > 0) {
                            // echo '<div class="' . $officeName . '-queue queue">'; // Open the queue div once
                            echo '<div class="' . $officeName . '-queue queue" id="' . $officeName . 'QueueContainer">';

                            while ($officeRow = $officeDataResult->fetch_assoc()) {
                                $window = $officeRow["window"];
                                $queueNumber = $officeRow["queue_number"];

                                echo '<h2 class="queue-text">' . $window . ': ' . $queueNumber . '</h2>';
                            }

                            echo '</div>'; // Close the queue div
                        } else {
                            // Display an empty queue container if no data is found for the current office
                            echo '<div class="' . $officeName . '-queue queue">';
                            echo '<h2 class="queue-text">-</h2>';
                            echo '</div>';
                        }

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
                    success: function(data) {
                        $('#<?php echo $officeName; ?>QueueContainer').html(data);
                    }
                });
            <?php } ?>
        }

        // Fetch queue data on page load
        fetchQueueData();

        setInterval(fetchQueueData, 5000);

        //FOR PENDING QUEUE
        function fetchPendingQueue() {
            $.ajax({
                url: 'fetch_pending_queue.php',
                type: 'GET',
                success: function(data) {
                    $('#pendingQueue').html(data);
                }
            });
        }

        // Fetch pending queue data on page load
        fetchPendingQueue();

        setInterval(fetchPendingQueue, 5000);
    </script>
    <script src="script/displayscript.js"></script>
</body>

</html>