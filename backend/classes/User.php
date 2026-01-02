<?php

    require_once "../config/database.php";

    abstract class User {
        protected $id;
        protected $name;
        protected $email;
        protected $password;
        protected $role;
        protected $status;

        public function __construct($id, $name, $email, $password, $role, $status = "active"){
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->role = $role;
            $this->status = $status;
        }

        public static function creat($name, $email, $password, $role, $pdo){
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql =  "INSERT INTO users (name, email, password, role, status)
            VALUE (:name, :email, :password, :role, 'active')";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => $role
            ]);

            return new class($pdo->lastInsertId(), $name, $email, $hashedPassword, $role) extends User {};
        }

        // verify password  
        public function verifyPassword($pass){
            return password_verify($pass, $this->password);
        }

        // geters methods
        public function getId() { return $this->id; }
        public function getName() { return $this->name; }
        public function getEmail() { return $this->email; }
        public function getRole() { return $this->role; }
        public function getStatus() { return $this->status; }

        // find user by he's email
        public static function findByEmail ($email, $pdo) {
            $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$data) return null;

            return new class (
                $data['id'],
                $data['name'],
                $data['email'],
                $data['password'],
                $data['role'],
                $data['status']
            ) extends User {};
        }
    }
?>