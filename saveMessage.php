<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chat";

// Create connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($servername, $username, $password, $dbname, 3306);
$conn->set_charset('utf8mb4');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Wenn JSON als als content type verwendet wird ("Content-type": "application/json; charset=UTF-8"): 
// $message = json_decode(file_get_contents('php://input'))->text;
$sql = "INSERT INTO Message (Uuid, Text) VALUES (unhex(replace(uuid(),'-','')),'" . $_POST['text'] . "');";

if ($conn->query($sql) === TRUE) {
  // console_log("New record created successfully");
} else {
  // console_log("Error: " . $sql . "<br>" . $conn->error);
}

$conn->close();