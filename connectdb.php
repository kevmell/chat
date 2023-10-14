<!DOCTYPE html>
<html lang="en">

<head>
  <title>Connection</title>
</head>

<body>

  <?php
  $dirPath = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT'])) . '/htdocs/chat/newMessage/';
  echo __DIR__ . "<br>";
  echo substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT'])) . "<br>";
  echo "Teste Vebindung zur Datenbank<br>";
  $mysqli = new mysqli("localhost", "root", "", "chat");
  if ($mysqli->connect_errno) {
    die("Verbindung fehlgeschlagen: <br>" . $mysqli->connect_error . "<br>");
  } else {
    echo "Verbindung hergestellt<br>";
  }
  $id = 100;
  $sql = "SELECT * FROM Message";
  $statement = $mysqli->prepare($sql);
  $statement->execute();

  $result = $statement->get_result();

  while ($row = $result->fetch_object()) {
    echo "UUID: " . $row->Uuid . "; Text:" . $row->Text . "<br>";
  }

  // $id = 100;
  // $sql = "SELECT * FROM Fenster";
  // $statement = $mysqli->prepare($sql);
  // $statement->execute();

  // $result = $statement->get_result();

  // while ($row = $result->fetch_object()) {
  //   echo "ID: " . $row->id . "; Anzahl:" . $row->anzahl;
  // }
  ?>