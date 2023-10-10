<?php
header("Cache-Control: no-store");
header("Content-Type: text/event-stream");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chat";

$timeOfLastMessage = strtotime("-1 year", time());

while (true) {
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT Time, Text FROM Message WHERE DATE(Time) > from_unixtime(" . $timeOfLastMessage . ") ORDER BY Time";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      $timeOfLastMessage = strtotime($row["Time"]);

      echo "event: newMessage\n";
      echo 'data: Server:' . $row["Text"];
      echo "\n\n";

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
