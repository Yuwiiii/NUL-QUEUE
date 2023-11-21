<?php
@include '../database.php';

$sql = "SELECT * FROM admission_logs";
$result = $conn->query($sql);

if ($result = mysqli_query($conn, $sql)) {
    $customerrowcount = mysqli_num_rows($result);
    echo $customerrowcount;
}

?>