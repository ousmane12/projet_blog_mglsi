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
    $result = $post->read();
    //Get row count
    $num = $result->rowCount();
    //Check if any post 
    if ($num > 0){
        //Post array
        $post_array = array();
        $post_array['data'] = array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $post_item = array(
                'id' => $id,
                'titre' => $titre,
                'contenu' => html_entity_decode($contenu),
                'dateCreation' => $dateCreation,
                'dateModification' => $dateModification,
                'categorie' => $category_name,
                'auteur' => $auteur
            );
            //Push to 'data'
            array_push($post_array['data'], $post_item);
        }
        //turn into json
        echo json_encode($post_array);
    }else{
        echo json_encode(array('Message'=>'No posts found'));
    }
