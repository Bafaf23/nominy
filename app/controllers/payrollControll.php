<?php
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'process_single_payroll') {

  // Recibir datos básicos
  $id_user = $_POST['id_user'];
  $amount = $_POST['amount']; // Este es el monto NETO final
  $periodo = $_POST['periodo'];
  $bank = $_POST['bank'] ?? 'No especificado';

  // Recibir deducciones de ley (vienen del modal)
  $sso = $_POST['sso'] ?? 0;
  $spf = $_POST['spf'] ?? 0;
  $faov = $_POST['faov'] ?? 0;
  $total_deductions = $_POST['total_deductions'] ?? 0;

  // 1. Insertar en el historial detallado de pagos individuales
  // Asegúrate de que tu tabla individual_payments tenga estas columnas
  $sql = "INSERT INTO individual_payments 
            (id_user, amount, sso_amount, spf_amount, faov_amount, period, bank, payment_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

  $stmt = $conn->prepare($sql);
  // Tipos: i = integer, d = double (decimal), s = string
  $stmt->bind_param("iddddss", $id_user, $amount, $sso, $spf, $faov, $periodo, $bank);

  if ($stmt->execute()) {

    // 2. Insertar en el historial global de nómina
    $sqlGlobal = "INSERT INTO payroll_history (status, periode, monto_pagado, bank, date) 
                      VALUES ('PAGADO', ?, ?, ?, NOW())";

    $stmtG = $conn->prepare($sqlGlobal);
    $stmtG->bind_param("sds", $periodo, $amount, $bank);
    $stmtG->execute();

    // Redirigir con éxito
    header("Location: ../../views/dashboard/personal.php?status=success&paid=" . $amount);
  } else {
    // Redirigir con error técnico
    header("Location: ../../views/dashboard/personal.php?status=error&msg=db_fail");
  }

  $stmt->close();
  $conn->close();
  exit;
}
