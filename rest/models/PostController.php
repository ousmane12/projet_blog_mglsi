<?php
    include_once '../config/Database.php';
    include_once 'Post.php';
    //header('Access-Control-Allow-Origin: *');
    class PostController
    {
        //public $post;


        public function __construct(){
            //$this->post = $post;
            $this->database = new Database();
            $this->db = $this->database->connect();
            $this->post = new Post($this->db);
        }

        function get($type){
            $dataType = $type != 'json' ? $type : 'json';
            //$post->libelle = isset($_GET['categorie']) ? $_GET['categorie'] : die();
            $dataType == 'xml' ? header("Content-Type: application/xml; charset=UTF-8") : header("Content-Type: application/json; charset=UTF-8");
            $result = $this->post->read();
            $num = $result->rowCount();
            //Check if any post 
            if ($num > 0){
                //Post array
                $post_array = array();
                $post_array['Article'] = array();
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
                    array_push($post_array['Article'], $post_item);
                }
                //turn into json
                //$json = ;
                //$xml = $post->xml_encode($post_array);
                //$xml = new SimpleXMLElement('<Article/>');
                //$r = $post->to_xml($xml, $post_array);
    
                $res = $dataType == 'json' ? json_encode($post_array): $this->post->xml_encode($post_array);
                echo $res;
            }else{
                $res = $dataType == 'json' ? json_encode(array('Message'=>'No posts found')): $this->post->xml_encode(array('Message'=>'No posts found'));
                //echo json_encode(array('Message'=>'No posts found'));
                echo res;
            }
    
        }
//articles by category
        public function get_by_cat($categorie,$type){
            $dataType = $type != 'json' ? $type : 'json';
            $dataType == 'xml' ? header("Content-Type: application/xml; charset=UTF-8") : header("Content-Type: application/json; charset=UTF-8");
            $this->post->libelle = $categorie;
            $results = $this->post->read_by_cat();
            $num = $results->rowCount();
            //Check if any post 
            if ($num > 0){
                //Post array
                $post_array = array();
                $post_array['Article'] = array();
                while($row = $results->fetch(PDO::FETCH_ASSOC)){
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
                    array_push($post_array['Article'], $post_item);
                }
                //turn into json
                $res = $dataType == 'json' ? json_encode($post_array): $this->post->xml_encode($post_array);
                echo $res;
                //echo json_encode($post_array);
            }else{
                $res = $dataType == 'json' ? json_encode(array('Message'=>'No posts found')): $this->post->xml_encode(array('Message'=>'No posts found'));
                //echo json_encode(array('Message'=>'No posts found'));
                echo res;
            }
        }

        public function get_all_cat($type){
            $dataType = $type != 'json' ? $type : 'json';
            $dataType == 'xml' ? header("Content-Type: application/xml; charset=UTF-8") : header("Content-Type: application/json; charset=UTF-8");
            $results = $this->post->regroupCategories();
            $res = $this->post->regroupArticles();
            
            //JSON encode the result returned from post.regroupArticles
            //print_r(rowCount($res[0]));
                //echo json_encode($res);
            $re = $dataType == 'json' ? json_encode($res): $this->post->xml_encode($res);
            echo $re;
            
        }

        public function get_by_id($id, $type){
           
            $dataType = $type != null ? $type : 'json';
            $dataType == 'xml' ? header("Content-Type: application/xml; charset=UTF-8") : header("Content-Type: application/json; charset=UTF-8");
            //$this->post->id = isset($_GET['id']) ? $id : die();
            //echo $id;
            //Get post
            $this->post->id = $id;
            $this->post->read_single($id);
            //create single post array
            $post_arr = array(
                'id' => $this->post->id,
                'titre' => $this->post->titre,
                'contenu' => $this->post->contenu,
                'dateCreation' => $this->post->dateCreation,
                'dateModification' => $this->post->dateModification,
                'categorie' => $this->post->category_name,
                'auteur' => $this->post->auteur
            );
            //print_r($post_arr);
            $resp = $dataType == 'json' ? json_encode($post_arr): $this->post->xml_encode($post_arr);
            echo $resp;

        }
        public function displayApiDocumentation()
        {
        //header('Location: '.WEBROOT.'apidoc/index.html');
        print_r('Hello');
    }
    }