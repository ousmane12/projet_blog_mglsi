<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Regsiter user
    public function register($data){
      $this->db->query('INSERT INTO user (nom, prenom, username, password, email, role, token) VALUES("'.$data['nom'].'", "'.$data['prenom'].'", "'.$data['username'].'", "'.$data['password'].'", "'.$data['email'].'", "'.$data['role'].'", "'.$data['token'].'")');
      
      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Login User
    public function login($email, $password){
        $this->db->query('SELECT * FROM user WHERE email = :email');
        $this->db->bind(':email', $email);
  
        $row = $this->db->single();
  
        $hashed_password = $row->password;
        if(password_verify($password, $hashed_password)){
          return $row;
        } else {
          return false;
        }
      }

    // Find user by email
    public function findUserByEmail($email){
      $this->db->query('SELECT * FROM user WHERE email = :email');
      // Bind value
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      // Check row
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    // Get User by ID
    public function getUserById($id){
        $this->db->query('SELECT * FROM user WHERE id = '.$id.'');
        $row = $this->db->single();
        return $row;
      }

    public function getList(){
        $this->db->query('SELECT * FROM user WHERE role = "editeur"');
        $row = $this->db->resultSet();
      // Check row
      if($this->db->rowCount() > 0){
        return $row;
      } else {
        return array('Error' => 'No user found');
      }
      }

      public function deleteUser($id){
        $this->db->query('DELETE FROM user WHERE id = '.$id.'');
        // Bind values
        // Execute
        if($this->db->execute()){
          return true;
        } else {
          return false;
        }
      }

      public function updateUser($data){
        $this->db->query('UPDATE user SET nom = "'.$data['nom'].'", prenom = "'.$data['prenom'].'", username = "'.$data['username'].'", password = "'.$data['password'].'", token = "'.$data['token'].'", role = "'.$data['role'].'" WHERE id = '.$data['id'].'');
        // Execute
        if($this->db->execute()){
          return true;
        } else {
          return false;
        }
      }
  }