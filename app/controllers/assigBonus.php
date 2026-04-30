<?php

include "conexion.php";

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
