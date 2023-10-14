<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Connection: close");
header("Content-Type: text/event-stream");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chat";

$timeOfLastMessage = strtotime("-1 year", time());

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SET SESSION query_cache_type = OFF;";
$conn->query($sql);
$conn->close();

while (true) {
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT SQL_NO_CACHE Time, Text FROM Message WHERE DATE(Time) > from_unixtime(" . $timeOfLastMessage . ") ORDER BY Time";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      $timeOfLastMessage = strtotime($row["Time"]);

      echo "event: newMessage\n";
      echo 'data: Server:' . $row["Text"];
      echo "\n\n";

      if (ob_get_contents()) ob_end_clean();
      if (ob_get_length()) ob_end_clean();
      ob_clean();
      ob_end_flush();
      flush();
    }
  }
  $conn->close();

  // Break the loop if the client aborted the connection (closed the page)
  if (connection_aborted()) break;

  // echo "event: newMessage\n";
  // echo 'data: ' . $timeOfLastMessage;
  // echo "\n\n";

  // ob_end_flush();
  // flush();
  sleep(1);
}
