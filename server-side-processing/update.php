

<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the required fields are set
if (isset($_POST['id']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['user_phone']) && isset($_POST['user_email']) && isset($_POST['gender'])) {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $user_phone = $_POST['user_phone'];
    $user_email = $_POST['user_email'];
    $gender = $_POST['gender'];

    // Update query
    $sql = "UPDATE myguests SET first_name=?, last_name=?, user_phone=?, user_email=?, gender=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $first_name, $last_name, $user_phone, $user_email, $gender, $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Missing required fields!";
}

$conn->close();
?>

