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
      header("Location:../../index.php");
      exit;
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
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      } 

      $_SESSION['user_id']  = $user['id'];
      $_SESSION['dni']      = $user['dni'];
      $_SESSION['name']     = $user['name'];
      $_SESSION['lastName'] = $user['last_name'];
      $_SESSION['id_role'] = $user['id_role'];
      $_SESSION['name_role']     = $user['name_role'];
      $_SESSION['date_entry'] = $user['date_entry'];
      $_SESSION['salary'] = $user['salary'];
      $_SESSION['id_bonuses'] = $user['id_bonuses'];


      header("Location: ../../views/dashboard/dashboard.php");;
      exit;
    } else {
        header("Location: ../../index.php?msg=Credenciales incorrectas o cuenta aún no aprobada por RRHH&type=error");
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