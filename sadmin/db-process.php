<?php
@include '../database.php';

if ($_GET['action'] == 'customers') {
    
    $sql = "SELECT * FROM queue";
    $result = $conn->query($sql);

    if ($result = mysqli_query($conn, $sql)) {
        $customerrowcount = mysqli_num_rows($result);
        echo $customerrowcount;
    }
} elseif ($_GET['action'] == 'completed') {
    
    $sql = "SELECT * FROM queue WHERE status = '1'";
    $result = $conn->query($sql);

    if ($result = mysqli_query($conn, $sql)) {
        $customerrowcount = mysqli_num_rows($result);
        echo $customerrowcount;
    }
    
} elseif ($_GET['action'] == 'pending') {
    
    $sql = "SELECT * FROM queue WHERE status = '0'";
    $result = $conn->query($sql);

    if ($result = mysqli_query($conn, $sql)) {
        $customerrowcount = mysqli_num_rows($result);
        echo $customerrowcount;
    }
}
elseif ($_GET['action'] == 'accounts') {
    
    $sql = "SELECT * FROM user_accounts";
    $result = $conn->query($sql);

    if ($result = mysqli_query($conn, $sql)) {
        $customerrowcount = mysqli_num_rows($result);
        echo $customerrowcount;
    }


   
}
elseif ($_GET['action'] == 'colleges') {
    
    $sql = "SELECT * FROM colleges";
    $result = $conn->query($sql);

    if ($result = mysqli_query($conn, $sql)) {
        $customerrowcount = mysqli_num_rows($result);
        echo $customerrowcount;
    }
}elseif ($_GET['action'] == 'offices') {
    $sql = "SELECT * FROM offices";
    $result = $conn->query($sql);

    if ($result = mysqli_query($conn, $sql)) {
        $customerrowcount = mysqli_num_rows($result);
        echo $customerrowcount;
    } 
}
else {
    echo "Invalid action.";
}
?>