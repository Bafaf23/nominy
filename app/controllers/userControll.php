<?php
include "conexion.php";
require_once "../models/Users.php";

class UserCotroll {
  public function handleRegister(){
    global $conn;

    $dni      = $_POST['dni'] ?? null;
    $name     = $_POST['name'] ?? null;
    $lastName = $_POST['lastName'] ?? null;
    $email    = $_POST['email'] ?? null;
    $pass     = $_POST['pass'] ?? null;
    $passConfir = $_POST['passConfir'] ?? null;

    if(!$dni || !$name || !$lastName || !$email || !$pass){
      header("Location: ../views/register.php?success=campo_vacios");
      exit;
    }

    if($pass !== $passConfir) {
      header("Location: ../../views/register.php?success=no_coinciden");
      exit;
    }

    $userModel = new Users($conn);
    $result = $userModel->register($dni, $name, $lastName, $email, $pass);

    if($result === TRUE){
      header("Location:../../views/register.php?success=registrado");
    } else {
      echo "Error: " . ($result ?: "No se pudo conectar con la base de datos.");
    }
  }

  public function handleLogin(){
    global $conn;

    $userName = $_POST["userName"] ?? null;
    $password = $_POST["password"] ?? null;

    if(!$userName || !$password){
      header("Location: /index.php?success=campo_vacios");
      exit;
    }

    $userModel = new Users($conn);
    $user = $userModel->login($userName, $password);

    if($user){
      session_start();
      $_SESSION['user_id'] = $user;
      setcookie($user['id'], $user['name'], $user['lastName'], $user['role']);
      header("Location: ../../views/dashboard/dashboard.php");;
      exit;
    } else {
      header("Location: ../../index.php?error=datos_incorrectos");
      exit;
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $controller = new UserCotroll();
  if (isset($_POST['action']) && $_POST['action'] === 'login') {
      $controller->handleLogin();
  } else {
      $controller->handleRegister();
  }
}
?>