<?php 
    class Database {
        // DB Params
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $dbname = 'myblog';
        private $con;

        // DB Connect
        public function connect() {
            $this->con = null;

            try {
                $this->con = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);

                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }

            return $this->con;
        }
    }
?>