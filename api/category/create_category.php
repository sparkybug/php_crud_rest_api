<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-type; application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // DB Instantiation
    $database = new Database();
    $db = $database->connect();

    // Category object Instantiation
    $category = new Category($db);

    // Get Category Data
    $data = json_decode(file_get_contents("php://input"));

    $category->id = $data->id;
    $category->name = $data->name;

    // Create Categories
    if($category->create_category()) {
        echo json_encode(
            array('message' => 'Category Created')
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not Created')
        );
    }
?>