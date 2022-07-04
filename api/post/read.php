<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-type; application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // DB Instantiation
    $database = new Database();
    $db = $database->connect();

    // Post object Instantiation
    $post = new Post($db);

    // Blog post query
    $result = $post->read();

    // GET row count
    $num = $result->rowCount();

    // Check for posts
    if($num > 0) {
        // Post array
        $posts_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $post_item = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            // Push to "data"
            array_push($posts_arr['data'], $post_item);
        }

        // Convert to JSON and output
        echo json_encode($posts_arr);

    } else {
        // If NO posts
        echo json_encode(
            array('message' => 'NO posts found')
        );
    }
?>