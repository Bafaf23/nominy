<?php
include "conexion.php";
require_once "../models/Users.php";

class UserCotroll
{
  /**
   * Procesa la solicitud de registro de un nuevo usuario desde el frontend.
   * 
   * Realiza las siguientes tareas de control:
   * 1. Determina el flujo de redirección según el origen (Registro público o RRHH).
   * 2. Valida la integridad de los datos (campos obligatorios y coincidencia de contraseñas).
   * 3. Instancia el modelo 'Users' para ejecutar la persistencia en la base de datos.
   * 4. Redirecciona al usuario con parámetros de estado (success/error) para notificaciones UI.
   *
   * @global mysqli $conn Instancia de conexión global a la base de datos.
   * @return void Realiza redirecciones de cabecera (header) y finaliza la ejecución.
   */
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

  /**
   * Gestiona el proceso de autenticación y la creación de la sesión de usuario.
   * 
   * Realiza las siguientes operaciones críticas:
   * 1. Validación de entrada: Asegura que las credenciales no lleguen nulas.
   * 2. Verificación de identidad: Invoca al modelo para validar email y contraseña.
   * 3. Persistencia de estado: Inicia la sesión PHP y almacena un snapshot del perfil 
   *    del usuario (DNI, Rol, Sueldo, Bonos) en la superglobal $_SESSION.
   * 4. Control de flujo: Redirecciona al Dashboard en caso de éxito o al Login con 
   *    mensajes de error descriptivos en caso de fallo.
   *
   * @global mysqli $conn Instancia de conexión global a la base de datos.
   * @return void Ejecuta redirecciones HTTP y finaliza el script.
   */
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


  /**
   * Gestiona el cambio de estado (Activo/Inactivo) de un trabajador.
   * 
   * Este controlador actúa como intermediario para:
   * 1. Capturar el ID del usuario y el nuevo estado desde una solicitud POST.
   * 2. Invocar al modelo 'Users' para persistir el cambio en la base de datos.
   * 3. Manejar el flujo de redirección hacia la vista de gestión de personal, 
   *    enviando parámetros de éxito o error para retroalimentación visual.
   *
   * @global mysqli $conn Instancia de conexión global a la base de datos.
   * @return void Ejecuta la redirección y finaliza el proceso.
   */
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

  /**
   * Procesa la solicitud de actualización de datos de un trabajador.
   * 
   * Este controlador realiza las siguientes acciones:
   * 1. Captura el conjunto de datos provenientes del formulario de edición (POST).
   * 2. Coordina con el modelo 'Users' para ejecutar la actualización compleja 
   *    que involucra tanto la tabla de usuarios como la de bancos.
   * 3. Gestiona el flujo de redirección post-edición, informando al usuario 
   *    sobre el resultado de la operación mediante parámetros en la URL.
   *
   * @global mysqli $conn Instancia de conexión global a la base de datos.
   * @return void Redirecciona al panel de gestión de personal y finaliza el script.
   */
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

/**
 * Enrutador de Peticiones POST - Módulo de Usuarios.
 * 
 * Este flujo actúa como un despachador (Dispatcher) que:
 * 1. Filtra las solicitudes para asegurar que solo se procesen métodos POST.
 * 2. Evalúa el parámetro 'action' enviado desde los formularios.
 * 3. Deriva la ejecución al método correspondiente de la clase 'UserCotroll'.
 * 4. Implementa un caso por defecto (handleRegister) para capturar registros nuevos.
 */
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
