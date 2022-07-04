<?php
    class Post {
        // DB Stuff
        private $con;
        private $table ='posts';

        // Post properties
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        // Constructor with DB
        public function __construct($db)
        {
            $this->con = $db;
        }

        // GET posts
        public function read() {
            // Create query
            $query = 'SELECT 
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                FROM
                    ' . $this->table . ' p
                LEFT JOIN
                    categories c ON p.category_id = c.id
                ORDER BY
                    p.created_at DESC';

            // Prepared Statement
            $stmt = $this->con->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Single Post
        public function read_single() {
            // Create query
            $query = 'SELECT 
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                FROM
                    ' . $this->table . ' p
                LEFT JOIN
                    categories c ON p.category_id = c.id
                WHERE
                    p.id = ?
                LIMIT 0,1';

        // Prepared Statement
        $stmt = $this->con->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set Properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
        }

        // Create Post Function
        public function create_post() {
            // Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id';

            // Prepared statement
            $stmt = $this->con->prepare($query);

            // Clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
            
            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something bad happens
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Update Post Function
        public function update_post() {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET
                        title = :title,
                        body = :body,
                        author = :author,
                        category_id = :category_id
                    WHERE
                        id = :id';

            // Prepared statement
            $stmt = $this->con->prepare($query);

            // Clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);
            
            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something bad happens
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Delete Posts 
        public function delete_post() {
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