<?php
class LogoutControll
{
  /**
   * Controlador de Finalización de Sesión (Logout).
   * 
   * Este método garantiza la destrucción total de la sesión del usuario mediante:
   * 1. Limpieza de variables: Vacía el array superglobal $_SESSION.
   * 2. Invalidación de Cookies: Sobrescribe la cookie de sesión en el navegador 
   *    con una fecha de expiración pasada.
   * 3. Destrucción en Servidor: Elimina el archivo de sesión física en el servidor.
   * 
   * @return void Realiza una redirección al índice y finaliza la ejecución.
   */
  public function logout()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
      );
    }

    session_destroy();

    return header("Location: ../../index.php");
    exit;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $controller = new LogoutControll();
  $controller->logout();
}
