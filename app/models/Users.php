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
    // 1. Usamos AS id_usuario para que no se mezcle con el id del rol
    // 2. Traemos salary de la tabla roles (que es donde lo definiste)
    $sql = "SELECT 
                users.id AS id_usuario, 
                users.dni, 
                users.name, 
                users.last_name, 
                users.email, 
                users.date_entry, 
                users.is_active,
                roles.name_role,
                roles.salary
            FROM users 
            LEFT JOIN roles ON users.id_role = roles.id";

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
}
