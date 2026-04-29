<?php
class Users
{
  private $db;

  public function __construct($data_base_conextion)
  {
    $this->db = $data_base_conextion;
  }

  public function register($dni, $name, $lastName, $email, $pass)
  {
    try {
      $checkSql = "SELECT id FROM users WHERE email = ?";
      $checkStmt = $this->db->prepare($checkSql);
      $checkStmt->bind_param("s", $email);
      $checkStmt->execute();
      $checkStmt->store_result();

      if ($checkStmt->num_rows > 0) {
        $checkStmt->close();
        return "El usuario, ya esta registrado.";
      }
      $checkStmt->close();

      $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

      $sql = 'INSERT INTO users(dni, name, last_name, email, pass) VALUES (?,?,?,?,?)';
      $stmt = $this->db->prepare($sql);

      $stmt->bind_param("sssss", $dni, $name, $lastName, $email, $hashed_password);
      if ($stmt->execute()) {
        $stmt->close();
        return true;
      } else {
        $stmt->close();
        return false;
      }
    } catch (PDOException $e) {
      return false;
    }
  }

  /**
   * Manejo de login de la app
   * @param string $userName - Correo electrónico del usuario
   * @param string $pass - Clave del usuario que se compara con la registrada en el sistema. 
   * @return array|false - Array asociativo con los datos del usuario o false si falla.
   */
  public function login($userName, $pass)
  {
    $sql = "SELECT *, name_role, salary
    FROM users  
    LEFT JOIN roles ON users.id_role = roles.id 
    WHERE users.email = ? AND users.is_active = 1";

    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $userName);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      $row = $result->fetch_assoc();
      if (password_verify($pass, $row['pass'])) {
        $stmt->close();
        return $row;
      }
    }
    $stmt->close();
    return false;
  }


  public function getUsers()
  {
    $sql = "SELECT 
    u.id AS id_usuario, 
    u.dni, 
    u.name, 
    u.last_name, 
    u.email, 
    u.date_entry, 
    u.is_active,
    r.name_role,
    r.salary,
    b.name_bank,
    b.account,
    -- Agrupamos los nombres de los bonos en un solo string separado por comas
    GROUP_CONCAT(bn.name_bonuses SEPARATOR ', ') AS nombres_bonos,
    -- Sumamos el total de bonos para tener el ingreso extra
    IFNULL(SUM(bn.amount), 0) AS total_bonos
FROM users u
LEFT JOIN roles r ON u.id_role = r.id
LEFT JOIN bank b ON u.id_bank = b.id
-- Relación con la tabla intermedia y la tabla de bonos
LEFT JOIN user_bonuses ub ON u.id = ub.id_user
LEFT JOIN bonuses bn ON ub.id_bonus = bn.id
GROUP BY u.id";

    $stmt = $this->db->prepare($sql);

    if (!$stmt) {
      // Esto te dirá el error real si tu base de datos tiene otro detalle
      die("Error en SQL: " . $this->db->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $users = [];

    while ($row = $result->fetch_assoc()) {
      $users[] = $row;
    }

    $stmt->close();
    return !empty($users) ? $users : false;
  }


  public function updateStatus($id, $status)
  {
    $status = ($status == 1) ? 1 : 0;
    $sql = "UPDATE users SET is_active = ? WHERE id = ?";
    $stmt = $this->db->prepare($sql);

    if (!$stmt) return false;

    $stmt->bind_param("ii", $status, $id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
  }

  public function updateUser($id, $name, $date, $lastName, $role, $email, $nameBank, $account)
  {

    $checkSql = "SELECT id_bank FROM users WHERE id = ?";
    $checkStmt = $this->db->prepare($checkSql);
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $res = $checkStmt->get_result()->fetch_assoc();
    $idBankActual = $res['id_bank'] ?? null;
    $checkStmt->close();

    if ($idBankActual === null) {

      $insBank = "INSERT INTO bank (name_bank, account) VALUES (?, ?)";
      $stmtB = $this->db->prepare($insBank);
      $stmtB->bind_param("ss", $nameBank, $account);
      $stmtB->execute();
      $idBankActual = $this->db->insert_id;
      $stmtB->close();


      $upUserBank = "UPDATE users SET id_bank = ? WHERE id = ?";
      $stmtU = $this->db->prepare($upUserBank);
      $stmtU->bind_param("ii", $idBankActual, $id);
      $stmtU->execute();
      $stmtU->close();
    } else {
      $upBank = "UPDATE bank SET name_bank = ?, account = ? WHERE id = ?";
      $stmtB = $this->db->prepare($upBank);
      $stmtB->bind_param("ssi", $nameBank, $account, $idBankActual);
      $stmtB->execute();
      $stmtB->close();
    }
    $sqlUser = "UPDATE users SET 
    name = ?, 
    last_name = ?,
    date_entry = ?,
    email = ?, 
    id_role = ?
    WHERE id = ?";

    $stmt = $this->db->prepare($sqlUser);
    $stmt->bind_param("ssssii", $name, $lastName, $date, $email, $role, $id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
  }
}
