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
    foreach ($results as $result ) {
        $post_arrays =  array();
        $post_arrays['categorie'] = array();
        //Get row count
        //$num = $results->rowCount();
        //Check if any post 
        //if ($num > 0){
            //Post array
            $post_array = array();
            //$post_array['data'] = array();
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
                
                
                array_push($post_array, $post_item);
                $str = $post_array[$post_item['categorie']];
                
                 //Push to Post_arrays
            
            //turn into json
            array_push($post_arrays[$str],$post_array);
            }
            
           
            echo json_encode($post_arrays);
        //}else{
            //echo json_encode(array('Message'=>'No posts found'));
        //}
    }
