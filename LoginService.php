<?php

class LoginService
{
  private $dbContext;

  function __construct()
  {
    require_once __DIR__ . '/DbContext.php';
    $this->dbContext = new DbContext();
  }

  public function isUsernameExists($username)
  {
    $query = 'SELECT * FROM user where username = ?';
    $paramType = 's';
    $paramValue = array(
      $username
    );
    $resultArray = $this->dbContext->select($query, $paramType, $paramValue);

    return is_array($resultArray) && count($resultArray) > 0;
  }

  public function isEmailExists($email)
  {
    $query = 'SELECT * FROM user where email = ?';
    $paramType = 's';
    $paramValue = array(
      $email
    );
    $resultArray = $this->dbContext->select($query, $paramType, $paramValue);

    return is_array($resultArray) && count($resultArray) > 0;
  }

  public function registerMember()
  {
    if ($this->isUsernameExists($_POST["username"])) {
      return array(
        "status" => "error",
        "message" => "Der Benutzername existiert bereits."
      );
    }

    if ($this->isEmailExists($_POST["email"])) {
      return array(
        "status" => "error",
        "message" => "Die E-Mail existiert bereits."
      );
    }

    if (!empty($_POST["signup-password"])) {
      $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
    }

    $query = 'INSERT INTO user (username, password, email) VALUES (?, ?, ?)';
    $paramType = 'sss';
    $paramValue = array(
      $_POST["username"],
      $hashedPassword,
      $_POST["email"]
    );
    $memberId = $this->dbContext->insert($query, $paramType, $paramValue);

    if (!empty($memberId)) {
      return array(
        "status" => "success",
        "message" => "Du hast dich erfolgreich registriert."
      );
    }

    return array(
      "status" => "error",
      "message" => "Beim Speichern deiner Daten ist ein Fehler aufgetreten. Bitte versuche es später erneut."
    );
  }

  public function getUser($property, $propertyName)
  {
    $query = 'SELECT * FROM user where ' . $propertyName . ' = ?';
    $paramType = 's';
    $paramValue = array(
      $property
    );
    $userRecord = $this->dbContext->select($query, $paramType, $paramValue);
    return $userRecord;
  }

  public function loginMember()
  {
    $userRecord = $this->getUser($_POST["email"], "Email");
    if (!empty($userRecord)) {
      if (!empty($_POST["password"])) {
        $password = $_POST["password"];
      }
      $hashedPassword = $userRecord[0]["Password"];

      if (password_verify($password, $hashedPassword)) {
        session_start();
        $_SESSION["username"] = $userRecord[0]["Username"];
        session_write_close();
        $url = "./admin.php";
        header("Location: $url");
        return;
      }
    }

    return "Falsche E-Mail oder Passwort.";
  }
}
