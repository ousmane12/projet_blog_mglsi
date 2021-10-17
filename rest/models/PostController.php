<?php

    /**
     * @OA\Info(
     *   title="GLSI news api",
     *   version="1.0.0",
     *   @OA\Contact(
     *     email="support@example.com"
     *   )
     * )
     */
    include_once '../config/Database.php';
    include_once 'Post.php';
    header('Access-Control-Allow-Origin: *');
    
    
    class PostController
    {
        //public $post;
        

        public function __construct(){
            //$this->post = $post;
            $this->database = new Database();
            $this->db = $this->database->connect();
            $this->post = new Post($this->db);
        }
           /**
         * @OA\Get(
         *     path="/public/index?action={article}&{type}", tags ={"public"}
         *     @OA\Response(response="200", description="success")
         *     @OA\Response(response="404", description="Error")
         *     @OA\Info 
         * )
         */
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
                    array_push($post_array['Articles'], $post_item);
                }
                //turn into json
                //$json = ;
                //$xml = $post->xml_encode($post_array);
                //$xml = new SimpleXMLElement('<Article/>');
                //$r = $post->to_xml($xml, $post_array);
    
                $res = $dataType == 'json' ? json_encode($post_array): $this->generate_valid_xml_from_array($post_array,  'article');
                echo $res;
            }else{
                $res = $dataType == 'json' ? json_encode(array('Message'=>'No posts found')): $this->generate_xml_from_array(['message' => 'Aucun article trouvé !'], 'message');
                //echo json_encode(array('Message'=>'No posts found'));
                echo $res;
            }
    
        }
//articles by category
        public function get_by_cat($categorie,$type){
            $dataType = $type != 'json' ? $type : 'json';
            $dataType == 'xml' ? header("Content-Type: application/xml; charset=UTF-8") : header("Content-Type: application/json; charset=UTF-8");
            $this->post->libelle = $categorie;
            $results = $this->post->read_by_cat($categorie);
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
                    array_push($post_array['Articles'], $post_item);
                }
                //turn into json
                $res = $dataType == 'json' ? json_encode($post_array): $this->generate_valid_xml_from_array($post_array,  'article');
                echo $res;
                //echo json_encode($post_array);
            }else{
                $res = $dataType == 'json' ? json_encode(array('Message'=>'No posts found')): $this->generate_xml_from_array(['message' => 'Aucun article trouvé !'], 'message');
                //echo json_encode(array('Message'=>'No posts found'));
                echo $res;
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
            $re = $dataType == 'json' ? json_encode($res): $this->generate_valid_xml_from_array($res,  'article');
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
            $resp = $dataType == 'json' ? json_encode($post_arr): $this->generate_valid_xml_from_array($post_arr,  'article');
            echo $resp;
            

        }
        public function displayApiDocumentation()
        {
        header('Location: '.'public/documentation/index.html');
        //print_r('Hello');
        }

        private function generate_xml_from_array($array, $node_name)
        {
        $xml = '';
        /*$xml = '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";*/

        if (is_array($array) || is_object($array))
        {
            foreach ($array as $key => $value)
            {
                if (is_numeric($key))
                {
                    $key = $node_name;
                }

                $xml .= '<' . $key . '>' . "\n" . $this->generate_xml_from_array($value, $node_name) . '</' . $key . '>' . "\n";
            }
        }
        else
        {
            $xml = htmlspecialchars($array, ENT_QUOTES) . "\n";
        }

        return $xml;
        }

        private function generate_valid_xml_from_array($array, $node_name='node')
        {
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";

       
        $xml .= $this->generate_xml_from_array($array, $node_name);
       

        return $xml;
        }
    }