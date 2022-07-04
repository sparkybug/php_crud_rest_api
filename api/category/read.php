<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-type; application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // DB Instantiation
    $database = new Database();
    $db = $database->connect();

    // Category object Instantiation
    $category = new Category($db);

    // Category query
    $result = $category->read();

    // GET row count
    $num = $result->rowCount();

    // Check for categories
    if($num > 0) {
        // Category array
        $categories_arr = array();
        $categories_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $category_item = array(
                'id' => $id,
                'name' => $name,
                'created_at' => $created_at
            );

            // Push to "data"
            array_push($categories_arr['data'], $category_item);
        }

        // Convert to JSON and output
        echo json_encode($categories_arr);

    } else {
        // If NO categories
        echo json_encode(
            array('message' => 'NO Categories Found')
        );
    }
?>