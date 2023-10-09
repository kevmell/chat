<!DOCTYPE html>
<html lang="en">

<head>
  <title>Connection</title>
</head>

<body>

  <?php
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  $mysqli = new mysqli('localhost', 'root', 'root', 'chatdb', 3306); // you can omit the last argument
  $mysqli->set_charset('utf8mb4'); // always set the charset
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } else {
    echo "Connected to db server";
  }

  $sql = "INSERT INTO Message (Uuid, Text) VALUES (unhex(replace(uuid(),'-','')),'Testnachricht-php');";

  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  ?>