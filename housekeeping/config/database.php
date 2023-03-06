<?php 
    class Database {
        private $host           = "localhost";
        private $database_name  = "arcturu_scaffolding";
        private $username       = "arcturu_scaff22u";
        private $password       = "ravi@8448214581";
        public $conn;
        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }  
?>