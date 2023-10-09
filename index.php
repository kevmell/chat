<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat</title>
  <script type="module" src="./chat.js"></script>
</head>

<body>

  <!-- <?php
        $messages = [];

        if (isset($_POST['Nachricht'])) {
          array_push($messages, $_POST['Nachricht']);
        }

        foreach ($messages as $message) {
          echo $message;
        }

        ?> -->

  <div id="messages" class="messages">

  </div>
  <textarea id="Nachricht" name="Nachricht" rows="10" cols="50" placeholder="Ihre Nachricht"></textarea>
  <input id="send" type="submit" name="submit" class="submit-button" />
</body>

</html>