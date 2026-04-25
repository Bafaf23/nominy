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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $controller = new UserCotroll();
  $controller->handleRegister();
}
?>