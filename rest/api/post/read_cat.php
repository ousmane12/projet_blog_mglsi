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
    $results = $post->read_all_by_cat();
    
    foreach ($results as $result => $value) {
    //Get row count
    echo $result;
    //$num = $result->rowCount();
    $post_array = array();
    $post_array['data'] = array();
    
   
    //Check if any post 
    if ($result != null){
        //Post array
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
            $s = $post_item['categorie'];
            $post_arrays = array();
            $post_arrays[$s] = array();
            //Push to 'data'
            array_push($post_array['data'], $post_item);
        }
        //turn into json
        echo json_encode($post_arrays);
    }else{
        echo json_encode(array('Message'=>'No posts found'));
    }
}