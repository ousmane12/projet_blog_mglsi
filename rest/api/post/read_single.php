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

    //Get the ID from the url
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();
    //Get post
    $post->read_single();

    //create single post array
    $post_arr = array(
        'id' => $post->id,
        'titre' => $post->titre,
        'contenu' => $post->contenu,
        'dateCreation' => $post->dateCreation,
        'dateModification' => $post->dateModification,
        'categorie' => $post->category_name,
        'auteur' => $post->auteur
    );

    //Make JSON

    print_r(json_encode($post_arr));