<?php
include "conexion.php";


/**
 * Procesador de Cierre de Nómina Individual.
 * 
 * Este script realiza una transacción de pago doble:
 * 1. Registro de Pago Detallado: Almacena en 'individual_payments' el monto neto, 
 *    el banco y las retenciones legales (SSO, SPF, FAOV).
 * 2. Historial de Nómina: Registra en 'payroll_history' el evento de pago global 
 *    para fines de auditoría y reportes financieros.
 * 
 * @ulr_param string action Debe ser 'process_single_payroll' para ejecutar la lógica.
 * @post int    id_user          ID del trabajador a pagar.
 * @post double amount           Monto neto a transferir.
 * @post string periodo          Mes/Año correspondiente al pago.
 * @post double sso, spf, faov   Montos de las retenciones de ley aplicadas.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'process_single_payroll') {


  $id_user = $_POST['id_user'];
  $amount = $_POST['amount'];
  $periodo = $_POST['periodo'];
  $bank = $_POST['bank'] ?? 'No especificado';


  $sso = $_POST['sso'] ?? 0;
  $spf = $_POST['spf'] ?? 0;
  $faov = $_POST['faov'] ?? 0;
  $total_deductions = $_POST['total_deductions'] ?? 0;


  $sql = "INSERT INTO individual_payments 
            (id_user, amount, sso_amount, spf_amount, faov_amount, period, bank, payment_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

  $stmt = $conn->prepare($sql);

  $stmt->bind_param("iddddss", $id_user, $amount, $sso, $spf, $faov, $periodo, $bank);

  if ($stmt->execute()) {


    $sqlGlobal = "INSERT INTO payroll_history (status, periode, monto_pagado, bank, date) 
                      VALUES ('PAGADO', ?, ?, ?, NOW())";

    $stmtG = $conn->prepare($sqlGlobal);
    $stmtG->bind_param("sds", $periodo, $amount, $bank);
    $stmtG->execute();


    header("Location: ../../views/dashboard/personal.php?status=success&paid=" . $amount);
  } else {

    header("Location: ../../views/dashboard/personal.php?status=error&msg=db_fail");
  }

  $stmt->close();
  $conn->close();
  exit;
}
