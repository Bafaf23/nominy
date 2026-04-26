<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id'])) {
  header("Location: ../../index.php?error=no_autorizado");
  exit;
}

$nombre_seguro = $_SESSION['name'];
$inicial = substr($nombre_seguro, 0, 1);

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <!-- Fontawesone -->
  <script src="https://kit.fontawesome.com/a74559d35e.js" crossorigin="anonymous"></script>
  <title><?php echo isset($pageTitle) ? $pageTitle : "Sistema Nominy"; ?></title>
</head>
<body class="bg-gray-100 h-screen flex p-4 gap-4">
  <?php include __DIR__ . "/../components/molecule/asider.php";?>
  <main class="flex-1 bg-white rounded-2xl shadow-xl p-8 flex flex-col">