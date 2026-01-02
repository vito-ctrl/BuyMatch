<?php
    class Database {
        private $host = "localhost";
        private $dbname = "buymatch";
        private $user = "vito";
        private $pass = "vito123456789";
        
        public function connect() {
            try{
                return new PDO(
                    "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                    $this->user,
                    $this->pass,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die("DB Error: ". $e->getMessage());
            }   
        } 
    }

?>