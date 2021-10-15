<?php
    header('Access-Control-Allow-Origin: *');
    require_once('../models/PostController.php');

    $articleApiController = new PostController();

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'articles' && isset($_GET['type']))
            echo $articleApiController->get($_GET['type']);
        else if($_GET['action'] == 'article' && isset($_GET['id']) && isset($_GET['type']))
            echo $articleApiController->get_by_id($_GET['id'], $_GET['type']);
        else if($_GET['action'] == 'articlescategorie'&& isset($_GET['categorie']) && isset($_GET['type']))
            echo $articleApiController->get_by_cat($_GET['categorie'], $_GET['type']);
        else if($_GET['action'] == 'articlesByCategory' && isset($_GET['type']))
            echo $articleApiController->get_all_cat($_GET['type']);
    }
    else
        $articleApiController->displayApiDocumentation();