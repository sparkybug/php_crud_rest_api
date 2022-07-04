<?php
    class Category {
        // DB Stuff
        private $con;
        private $table ='categories';

        // Categories Properties
        public $id;
        public $name;
        public $created_at;

        // Constructor with DB
        public function __construct($db)
        {
            $this->con = $db;
        }

        // GET Categories
        public function read() {
            // Create query
            $query =  'SELECT
                    id,
                    name,
                    created_at
                FROM
                    ' . $this->table . '
                ORDER BY
                    created_at DESC';
            
            // Prepared statement
            $stmt = $this->con->prepare($query);

            // Execute statement
            $stmt->execute();

            return $stmt;
        }

        public function read_single() {
            // Create query
            $query = 'SELECT
                    id,
                    name,
                    created_at
                FROM
                    ' . $this->table . '
                WHERE
                    id = :id
                LIMIT 0,1';

            // Prepared statement
            $stmt = $this->con->prepare($query);

            //  Bind ID
            $stmt->bindParam(':id', $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->created_at = $row['created_at'];
        }

        // Create Category Function
        public function create_category() {
            // Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    id = :id,
                    name = :id';
            
            // Prepared statement
            $stmt = $this->con->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            
            // Bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something bad happens
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Update Category Function
        public function update_category() {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                SET
                    id = :id,
                    name = :name
                WHERE
                    id = :id';

            // Prepared Statement
            $stmt = $this->con->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));

            // Bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something bad happens
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Delete Category Function
        public function delete_category() {
            // Create query
            $query = 'DELETE FROM ' . $this->table .  ' WHERE id = :id';

            // Prepared statement
            $stmt = $this->con->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
 
            // Bind data
            $stmt->bindParam('id', $this->id);
 
            // Execute query
            if($stmt->execute()) {
                return true;
             }
 
            // Print error if something bad happens
            printf("Error: %s.\n", $stmt->error);
 
            return false;
        }
    }
?>