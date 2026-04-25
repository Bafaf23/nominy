<?php
class Users{
  private $db;

  public function __construct($data_base_conextion){
    $this->db = $data_base_conextion;
  }

  public function register($dni, $name, $lastName, $email, $pass){
    try{
      $checkSql = "SELECT id FROM users WHERE email = ?";
      $checkStmt = $this->db->prepare($checkSql);
      $checkStmt->bind_param("s", $email);
      $checkStmt->execute();
      $checkStmt->store_result();

      if($checkStmt->num_rows > 0){
        $checkStmt->close();
        return"El usuario, ya esta registrado.";
      }
      $checkStmt->close();

      $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

      $sql = 'INSERT INTO users(dni, name, last_name, email, pass) VALUE(?,?,?,?,?)';
      $stmt = $this->db->prepare($sql);

      $stmt->bind_param("sssss", $dni, $name, $lastName, $email, $hashed_password);
      if ($stmt->execute()) {
        $stmt->close();
        return true;
      } else {
        return false;
      }
      
    } catch (PDOException $e) {
      return false;
    }
  }
}
?>