<?php
class LogoutControll{
  public function logout(){
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    $_SESSION = [];

    if(ini_get("session.use_cookies")){
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