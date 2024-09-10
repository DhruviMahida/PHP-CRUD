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

// DataTables parameters
$limit = $_GET['length']; // Rows per page
$start = $_GET['start'];  // Offset
$search = $_GET['search']['value']; // Search value

// Query for total data count
$totalQuery = "SELECT COUNT(*) as total FROM myguests";
$totalResult = $conn->query($totalQuery);
$totalData = $totalResult->fetch_assoc()['total'];

// Query to fetch data with search and pagination
// $sql = "SELECT id, first_name, last_name, user_email, reg_date FROM myguests WHERE 1 ";
$sql = "SELECT id, CONCAT( first_name, ' ', last_name) AS Name, user_phone, user_email, gender  FROM myguests WHERE 1 ";

if (!empty($search)) {
    $sql .=  "AND (first_name LIKE '%$search%' 
    OR last_name LIKE '%$search%' 
    OR user_email LIKE '%$search%' 
    OR user_phone LIKE '%$search%'
    OR gender LIKE '%$search%')";
}

$totalFilteredResult = $conn->query($sql);
$totalFiltered = $totalFilteredResult->num_rows;

$sql .= " LIMIT $start, $limit";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $subArray = [];
    $subArray[] = $row['id'];
    $subArray[] = $row['Name'];
    $subArray[] = $row['user_phone'];
    $subArray[] = $row['user_email'];
    $subArray[] = $row['gender'];
    $data[] = $subArray;
}

// Prepare JSON data for DataTables
$jsonData = [
    "draw" => intval($_GET['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
];

echo json_encode($jsonData);

$conn->close();
?>
