<?php
require_once __DIR__ . '/LoginService.php';

if (isset($_POST["email"]) && isset($_POST["password"])) {
  $loginService = new LoginService();
  $loginFailure = $loginService->login();
}

session_start();
if (isset($_SESSION["message"])) {
  $message = $_SESSION["message"];

  unset($SESSION["message"]);
  session_destroy();
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chat</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <div class="row h-100">
    <div class="col-sm-12 my-auto">
      <div class="w-25 mx-auto">
        <form method="post">
          <?php
          if (!empty($loginFailure)) {
            echo '<p class="w-100 text-center">' . $loginFailure . '</p>';
          }
          if (!empty($message)) {
            echo '<p class="w-100 text-center">' . $message . '</p>';
          }
          ?>
          <input type="email" class="form-control my-2" id="email" name="email" placeholder="E-mail" required>
          <input type="password" class="form-control my-2" id="password" name="password" placeholder="Passwort" required>
          <input type="submit" value="Login" class="btn btn-primary w-100">
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>