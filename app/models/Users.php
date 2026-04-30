<?php
class Users
{
  /**
   * Propiedad privada que almacena la instancia de la conexión a la base de datos.
   * @var mysqli
   */
  private $db;

  /**
   * Constructor de la clase Users.
   * 
   * Inicializa la clase inyectando una conexión activa a la base de datos.
   * Esto permite que todos los métodos de la clase compartan el mismo canal
   * de comunicación con el servidor MySQL, optimizando el uso de recursos.
   *
   * @param mysqli $data_base_conextion Objeto de conexión (producido por mysqli_connect).
   */
  public function __construct($data_base_conextion)
  {
    $this->db = $data_base_conextion;
  }

  /**
   * Registra un nuevo usuario/trabajador en el sistema.
   * 
   * Realiza un proceso de registro seguro en tres pasos:
   * 1. Validación de Duplicidad: Verifica si el email ya existe para evitar registros duplicados.
   * 2. Encriptación: Aplica un hash robusto (BCRYPT) a la contraseña antes de almacenarla.
   * 3. Inserción Segura: Utiliza sentencias preparadas para guardar los datos personales y credenciales.
   *
   * @param string $dni      Documento Nacional de Identidad (V-XXXXXXXX).
   * @param string $name     Nombre(s) del trabajador.
   * @param string $lastName Apellido(s) del trabajador.
   * @param string $email    Correo electrónico (se usa como identificador único).
   * @param string $pass     Contraseña en texto plano (será encriptada).
   * 
   * @return bool|string     Retorna true si el registro fue exitoso, un mensaje de error 
   *                         si el usuario existe, o false si ocurre una falla técnica.
   */
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
    $sql = "SELECT u.*, r.name_role, r.salary
              FROM users u
              LEFT JOIN roles r ON u.id_role = r.id 
              WHERE u.email = ? AND u.is_active = 1";

    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      $row = $result->fetch_assoc();


      if (password_verify($pass, $row['pass'])) {
        $stmt->close();

        $id_user = $row['id'];
        $bonuses = [];

        $sqlBones = "SELECT b.name_bonuses AS nameBone, b.amount AS monte 
                            FROM user_bonuses ub
                            JOIN bonuses b ON ub.id_bonus = b.id
                            WHERE ub.id_user = ?";

        $stmtB = $this->db->prepare($sqlBones);
        $stmtB->bind_param("i", $id_user);
        $stmtB->execute();
        $resBones = $stmtB->get_result();

        while ($bone = $resBones->fetch_assoc()) {
          $bonuses[] = $bone;
        }
        $stmtB->close();

        $row['bonuses'] = $bonuses;

        return $row;
      }
    }

    if (isset($stmt)) $stmt->close();
    return false;
  }

  /**
   * Obtiene el listado exhaustivo de usuarios con sus perfiles laborales y financieros.
   * 
   * Realiza una consulta multitabla (JOIN) para consolidar:
   * 1. Información personal (nombre, DNI, email).
   * 2. Información laboral (cargo y sueldo base).
   * 3. Información bancaria (entidad y número de cuenta).
   * 4. Resumen de beneficios: concatena los nombres de los bonos y suma sus montos.
   *
   * @return array|false Devuelve un array de arreglos asociativos con los datos 
   *                     consolidados, o false si no existen registros.
   */
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

    GROUP_CONCAT(bn.name_bonuses SEPARATOR ', ') AS bonues,

    IFNULL(SUM(bn.amount), 0) AS total_bonos
    FROM users u
    LEFT JOIN roles r ON u.id_role = r.id
    LEFT JOIN bank b ON u.id_bank = b.id
    LEFT JOIN user_bonuses ub ON u.id = ub.id_user
    LEFT JOIN bonuses bn ON ub.id_bonus = bn.id
    GROUP BY u.id";

    $stmt = $this->db->prepare($sql);

    if (!$stmt) {
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

  /**
   * Cambia el estado de activación de un usuario (Soft Delete / Reactivación).
   * 
   * Este método permite habilitar o deshabilitar el acceso de un usuario al sistema
   * sin eliminar sus datos de la base de datos, manteniendo la integridad referencial.
   *
   * @param int $id     Identificador único del usuario (Primary Key).
   * @param int $status Estado deseado: 1 para Activo, 0 para Inactivo.
   * 
   * @return bool Devuelve true si la actualización fue exitosa, false en caso de error.
   */
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

  /**
   * Actualiza la información integral de un usuario y sus datos bancarios.
   * 
   * Este método realiza una gestión inteligente de datos:
   * 1. Verifica si el usuario ya posee un registro en la tabla 'bank'.
   * 2. Si no existe, crea el registro bancario y vincula el nuevo ID al usuario.
   * 3. Si existe, actualiza los datos bancarios actuales.
   * 4. Finalmente, actualiza los datos personales y de rol en la tabla 'users'.
   *
   * @param int    $id        ID del usuario a actualizar.
   * @param string $name      Nombre(s) del trabajador.
   * @param string $date      Fecha de ingreso al sistema.
   * @param string $lastName  Apellido(s) del trabajador.
   * @param int    $role      ID del rol/cargo asignado.
   * @param string $email     Correo electrónico institucional.
   * @param string $nameBank  Nombre de la entidad bancaria.
   * @param string $account   Número de cuenta bancaria (20 dígitos).
   * 
   * @return bool Devuelve true si toda la operación fue exitosa.
   */
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

  /**
   * Recupera el catálogo completo de bonificaciones configuradas en el sistema.
   * 
   * Este método consulta la tabla 'bonuses' para obtener todos los beneficios 
   * disponibles, ordenándolos alfabéticamente para facilitar su selección 
   * en interfaces de usuario (selects, checklists, etc.).
   *
   * @return array Lista de arreglos asociativos, donde cada elemento contiene 
   *               los detalles del bono (id, name_bonuses, amount).
   */
  public function getAvailableBonuses()
  {
    $sql = "SELECT * FROM bonuses ORDER BY name_bonuses ASC";
    $result = $this->db->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
    return $data;
  }

  /**
   * Calcula el resumen consolidado de ingresos para todos los trabajadores activos.
   * 
   * Realiza una agregación de datos combinando el sueldo base con las 
   * bonificaciones asignadas. Utiliza LEFT JOIN para garantizar que los 
   * empleados sin bonos también aparezcan en el listado con un valor de cero.
   *
   * @return array Lista de empleados con su sueldo base y el sumatorio total 
   *               de sus bonificaciones. Retorna un array vacío si falla la consulta.
   */
  public function getNominaTotal()
  {
    $sql = "SELECT 
                u.id_usuario, 
                u.name, 
                u.last_name, 
                u.dni, 
                u.salary,
                COALESCE(SUM(b.amount), 0) as total_bonos
            FROM users u
            LEFT JOIN user_bonuses ub ON u.id_usuario = ub.id_user
            LEFT JOIN bonuses b ON ub.id_bonus = b.id
            WHERE u.is_active = 1
            GROUP BY u.id_usuario";

    $result = $this->db->query($sql);


    if (!$result) {
      return [];
    }

    return $result->fetch_all(MYSQLI_ASSOC);
  }
}
