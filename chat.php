<!doctype html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chat</title>
  <link rel="stylesheet" href="style.css">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="client.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

  <div class="row h-100">
    <div class="col-sm-12 my-auto">
      <div class="card card-block gap-3 w-75 mx-auto">
        <div id="chat-box" class="grid gap-3">
        </div>
        <form class="mb-3" name="frmChat" id="frmChat">
          <input type="textarea" class="form-control m-2" name="chat-message" id="chat-message" placeholder="Deine Nachricht" required />
          <input type="submit" class="form-control m-2" id="btnSend" name="send-chat-message" value="Senden">
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>