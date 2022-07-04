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

    // Getting Category ID
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Categories
    $category->read_single();

    // Create array
    $category_arr = array(
        'id' => $category->id,
        'name' => $category->name,
        'created_at' => $category->created_at,
    );

    // Make JSON
    print_r(json_encode($category_arr));
?>