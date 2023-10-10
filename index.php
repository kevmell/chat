<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat</title>
  <script type="module" src="./chat.js"></script>
</head>

<body>

  <?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "chat";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT Text FROM Message ORDER BY Time";
  $result = $conn->query($sql);

  echo '<div id="messages" class="messages">';
  if ($result->num_rows > 0) {

    // output data of each row
    while ($row = $result->fetch_assoc()) {
      echo '<div class="message">' . $row["Text"] . '</div>';
    }
  }
  echo '</div>';
  $conn->close();
  ?>



  <textarea id="Nachricht" name="Nachricht" rows="10" cols="50" placeholder="Ihre Nachricht"></textarea>
  <input id="send" type="submit" name="submit" class="submit-button" />
</body>

</html>