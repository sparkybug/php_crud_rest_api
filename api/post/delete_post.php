<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-type; application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // DB Instantiation
    $database = new Database();
    $db = $database->connect();

    // Post object Instantiation
    $post = new Post($db);

    // Get Posted Data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to delete
    $post->id = $data->id;

    // Delete Posts
    if($post->delete_post()) {
        echo json_encode(
            array('message' => 'Post deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Post Not deleted')
        );
    }
?>