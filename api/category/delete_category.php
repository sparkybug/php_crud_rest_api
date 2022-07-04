<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-type; application/json');
    header('Access-Control-Allow-Methods: DELETE');
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

    // Set ID to delete
    $category->id = $data->id;

    // Delete Categories
    if($category->delete_category()) {
        echo json_encode(
            array('message' => 'Category deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not deleted')
        );
    }
?>