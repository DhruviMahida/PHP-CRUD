<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$user_phone = $_POST['user_phone'];
$user_email = $_POST['user_email'];
$gender = $_POST['gender'];

// Insert data into the database
$sql = "INSERT INTO myguests (first_name, last_name, user_phone, user_email, gender, reg_date)
        VALUES ('$first_name', '$last_name', '$user_phone', '$user_email', '$gender', NOW())";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
