<?php
include "conexion.php";
require_once "../models/Users.php";

class UserCotroll
{
  public function handleRegister()
  {
    global $conn;

    $origen = $_POST['origen'] ?? 'publico';
    $url_retun =  ($origen === 'rrhh') ? '../../views/dashboard/personal.php' : '../../views/register.php';

    $dni      = $_POST['dni'] ?? null;
    $name     = $_POST['name'] ?? null;
    $lastName = $_POST['lastName'] ?? null;
    $email    = $_POST['email'] ?? null;
    $pass     = $_POST['pass'] ?? null;
    $passConfir = $_POST['passConfir'] ?? null;

    if (!$dni || !$name || !$lastName || !$email || !$pass) {
      header("Location:" . $url_retun . "?success=campo_vacios");
      exit;
    }

    if ($pass !== $passConfir) {
      header("Location:" . $url_retun . "?success=no_coinciden");
      exit;
    }

    $userModel = new Users($conn);
    $result = $userModel->register($dni, $name, $lastName, $email, $pass);

    if ($result === TRUE) {
      $redirect_final = ($origen === 'rrhh') ? $url_retun . "?success=registrado" : "../../index.php?success=registrado";
      header("Location:" . $redirect_final);
      exit;
    } else {
      echo "Error: " . ($result ?: "No se pudo conectar con la base de datos.");
    }
  }

  public function handleLogin()
  {
    global $conn;

    $userName = $_POST["userName"] ?? null;
    $password = $_POST["password"] ?? null;

    if (!$userName || !$password) {
      header("Location: /index.php?success=campo_vacios");
      exit;
    }

    $userModel = new Users($conn);
    $user = $userModel->login($userName, $password);

    if ($user) {
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
      $_SESSION['bonuses'] = $user['bonuses'];
      $_SESSION['id_bonuses'] = $user['id_bonuses'];


      header("Location: ../../views/dashboard/dashboard.php");;
      exit;
    } else {
      header("Location: ../../index.php?msg=Credenciales incorrectas o cuenta aún no aprobada por RRHH&type=error");
      exit;
    }
  }

  public function handleToggleStatus()
  {
    global $conn;

    $idUser = $_POST['user_id'] ?? null;
    $newStatus = $_POST['new_status'] ?? null;

    if ($idUser !==  null) {
      $userModel = new Users($conn);
      $result = $userModel->updateStatus($idUser, $newStatus);

      if ($result) {
        header("Location: ../../views/dashboard/personal.php?success=estado_actualizado");
        exit;
      }
    }

    header("Location: ../../views/dashboard/personal.php?error=fallo_actualizacion");
    exit;
  }

  public function updateUser()
  {
    global $conn;

    $idUser = $_POST['user_id'];
    $name = $_POST['edit_name'];
    $lastName = $_POST['edit_last_name'];
    $date = $_POST['edit_date'];
    $email = $_POST['edit_email'];
    $role = $_POST['edit_role'];
    $account = $_POST['edit_bank_account'];
    $namneBank = $_POST['edit_bank_name'];


    /*  if (!$name || !$lastName || !$email || !$role || $date) {
      header("Location: ../../views/dashboard/personal.php?success=campo_vacios");
      exit;
    } */

    if ($idUser !== null) {
      $userModel = new Users($conn);
      $result = $userModel->updateUser($idUser, $name, $date, $lastName, $role, $email, $namneBank, $account);

      if ($result) {
        header("Location: ../../views/dashboard/personal.php?success=actualizacion_exitosa");
        exit;
      }
    }

    header("Location: ../../views/dashboard/personal.php?success=erro_al_procesar_la_actualizacion");
    exit;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $controller = new UserCotroll();
  if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $controller->handleLogin();
  } elseif (isset($_POST['action']) && $_POST['action'] === 'toggle_status') {
    $controller->handleToggleStatus();
  } elseif (isset($_POST['action']) && $_POST['action'] === "update_user") {
    $controller->updateUser();
  } else {
    $controller->handleRegister();
  }
}
