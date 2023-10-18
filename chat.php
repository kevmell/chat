<html>

<head>
  <link rel="stylesheet" href="style.css">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="client.js"></script>
</head>

<body>
  <?php if (isset($_POST['name'])) { ?>
    <script>
      const username = "<?= $_POST['name'] ?>";
    </script>
  <?php
  } else {
    header("Location: http://localhost");
    exit();
  } ?>

  <form name="frmChat" id="frmChat">
    <div id="chat-box"></div>
    <input type="text" name="chat-message" id="chat-message" placeholder="Message" class="chat-input chat-message" required />
    <input type="submit" id="btnSend" name="send-chat-message" value="Send">
  </form>
</body>

</html>