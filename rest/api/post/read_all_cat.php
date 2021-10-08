<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    //header('Content-Type: application/xml');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    //DB instanciation & connection

    $database = new Database();
    $db = $database->connect();

    //Instantiate Post

    $post = new Post($db);

    //Blog post query
    $results = $post->regroupCategories();
    $res = $post->regroupArticles();
    
    //JSON encode the result returned from post.regroupArticles
    //print_r(rowCount($res[0]));
        echo json_encode($res);

   
