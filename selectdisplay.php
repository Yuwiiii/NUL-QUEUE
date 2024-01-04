<!-- login.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <div style="text-align: center; margin-top: 50px;">
        <form action="validate_selection.php" method="post">
            <label for="officeSelected">Select Office: </label>
            <select name="officeSelected" required>
                <option value="all" ?>All Offices
                </option>
                <!-- Populate the dropdown with office names from the database -->
                <?php
                @include 'database.php';

                $sql = "SELECT DISTINCT officeName FROM offices";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["officeName"] . '">' . $row["officeName"] . '</option>';
                    }
                }
                ?>
            </select>
            <br><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>