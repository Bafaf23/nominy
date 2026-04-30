<?php

include "conexion.php";

/**
 * Controlador de Asignación de Bonificaciones.
 * 
 * Este script gestiona la relación muchos-a-muchos entre usuarios y bonos:
 * 1. Validación de Duplicidad: Verifica si el bono ya ha sido asignado al usuario 
 *    para evitar registros redundantes en la tabla intermedia.
 * 2. Persistencia de Relación: Inserta la vinculación en 'user_bonuses' mediante 
 *    sentencias preparadas para garantizar la seguridad.
 * 3. Feedback de Interfaz: Redirecciona al panel de personal con estados de 
 *    éxito o error (ya existe/fallo BD).
 * 
 * @post int id_user  Identificador único del trabajador.
 * @post int id_bonus Identificador del bono a asignar.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_user = $_POST['id_user'];
  $id_bonus = $_POST['id_bonus'];

  $check = $conn->prepare("SELECT id FROM user_bonuses WHERE id_user = ? AND id_bonus = ?");
  $check->bind_param("ii", $id_user, $id_bonus);
  $check->execute();
  $res = $check->get_result();

  if ($res->num_rows > 0) {
    header("Location: ../../views/dashboard/personal.php?error=already_exists");
  } else {
    $sql = "INSERT INTO user_bonuses (id_user, id_bonus) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_user, $id_bonus);

    if ($stmt->execute()) {
      header("Location: ../../views/dashboard/personal.php?success=assigned");
    } else {
      header("Location: ../../views/dashboard/personal.php?error=failed");
    }
  }
}
