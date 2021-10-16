<?php 
    class Post{
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        public function getPost(){
            $this->db->query('SELECT * FROM article');
            $result = $this->db->resultSet();
            return $result;
        }

        public function getPagination()
        {
        $articles = array();

        //$this->db->query('SELECT * FROM Article');
        //$art = $this->db->resultSet();
        $art = $this->getPost();
        //print_r($art);
        array_push($articles, $art);
        //print_r($articles);
        
        //$url = URLROOT;
        error_reporting(E_ERROR | E_PARSE);
        $url = explode('/', $_GET['url']);
        if(empty($_GET['url']) || $url[0] == 'index'){
            $page = 1;
            //print_r($page);
        }else{
            //print_r($url);
            $page = $url[1];
            //print_r($page);
        } 
        $nbre_total_articles = sizeof($articles[0]);
        //print_r($nbre_total_articles);
        $nbre_articles_par_page = 3;
        $last_page = ceil($nbre_total_articles / $nbre_articles_par_page);

        $page_num = $page;

        if($page_num < 1)
            $page_num = 1;
        else if($page_num > $last_page)
            $page_num = $last_page;

        $limit = 'LIMIT '.($page_num - 1) * $nbre_articles_par_page. ',' . $nbre_articles_par_page;

        $this->db->query('SELECT * FROM Article ORDER BY dateCreation DESC '.$limit);
        $articles = array();
        $arti = $this->db->resultSet();
        array_push($articles, $arti);


        $pagination = '';
        if($last_page != 1)
        {
            if($page_num > 1)
            {
                $previous = $page_num - 1;
                $pagination .= '<a  class="btn btn-primary" href="'.URLROOT.'/pages/'.$previous.'"><i class="fa fa-chevron-left"></i> Précédent</a> &nbsp; &nbsp;';
            }
            if($page_num != $last_page)
            {
                $next = $page_num + 1;
                $pagination .= '<a class="btn btn-primary" href="'.URLROOT.'/pages/'.$next.'">Suivant <i class="fa fa-chevron-right"></i></a> ';
            }
        }
        

        return ['articles' => $articles, 'pagination' => $pagination];
    }

    
        
        public function getCategories(){
            $this->db->query('SELECT * FROM categorie');
            $result = $this->db->resultSet();
            return $result;
        }

        public function getByid($id){
            $this->db->query('SELECT * FROM Article WHERE id = '.$id);
            $result = $this->db->resultSet();
            return $result;
        }

        public function updateCategorie($id){
            //this->db->query('UPDATE categorie SET libelle = '.$data['titre'].'');
            $result = $this->db->resultSet();
            return $result;
        }

        public function getByCategoryId($id){
            $this->db->query('SELECT * FROM Article WHERE categorie = '.$id);
            $result = $this->db->resultSet();
            if($this->db->rowCount() > 0){
                return $result;
            }else {
                return array('Error' =>'No post for this category');
            }
            
        }

        public function getCatById($id){
            $this->db->query('SELECT * FROM Categorie WHERE id = '.$id);
            $result = $this->db->resultSet();
            return $result;
        }

        public function getCatByName($libelle){
            //print_r($libelle);
            $req = 'SELECT DISTINCT id FROM categorie WHERE libelle = ' . "'$libelle'";
            //print_r($req);
            $this->db->query($req);
            $result = $this->db->single();
            //print_r($result->id);
            unset($this->db->PDOStatement);
            return $result->id;
           //
        }
        public function addPost($data){
            
            $categorie = $this->getCatByName($data['categories']);
            $this->db->query('INSERT INTO article (titre, contenu, auteur, categorie) VALUES("'.$data['titre'].'", "'.$data['contenu'].'", "'.$data['auteur'].'", '.$categorie.')');
            // Bind values
            
            
            //print_r($categorie);
            //print_r($categorie)
        
            // Execute
            //unset($this->db->PDOStatement);
            
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function updateArticle($data){
            $categorie = $this->getCatByName($data['categories']);
            $this->db->query('UPDATE article SET titre = "'.$data['titre'].'", contenu = "'.$data['contenu'].'", categorie= "'.$categorie.'" WHERE id = '.$data['id'].'');
            
            // Execute
            if($this->db->execute()){
              return true;
            } else {
              return false;
            }
          }
          public function deletePost($id){
            $this->db->query('DELETE FROM article WHERE id = :id');
            // Bind values
            $this->db->bind(':id', $id);
      
            // Execute
            if($this->db->execute()){
              return true;
            } else {
              return false;
            }
          }

        
    }