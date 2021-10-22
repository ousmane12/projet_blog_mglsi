<?php 
    class Category{
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        
        public function getCategories(){
            $this->db->query('SELECT * FROM categorie');
            $result = $this->db->resultSet();
            return $result;
        }

        public function getByid($id){
            $this->db->query('SELECT * FROM categorie WHERE id = '.$id);
            $result = $this->db->resultSet();
            return $result;
        }

        public function updateCategorie($id){
            //this->db->query('UPDATE categorie SET libelle = '.$data['titre'].'');
            $result = $this->db->resultSet();
            return $result;
        }

        public function getByCategoryId($id){
            $this->db->query('SELECT * FROM categorie WHERE id = '.$id);
            $result = $this->db->resultSet();
            if($this->db->rowCount() > 0){
                return $result;
            }else {
                return array('Error' =>'No post for this category');
            }
            
        }

        public function getCatByUser($auteur){
            print_r($this->db->query('SELECT * FROM categorie WHERE auteur = '.$auteur.''));
            $result = $this->db->resultSet();
            //print_r($result);
            //unset($this->db->PDOStatement);
            return $result;
            
        }


        public function getCatById($id){
            $this->db->query('SELECT * FROM Categorie WHERE id = '.$id);
            $result = $this->db->resultSet();
            return $result;
        }

        public function getCatByName($libelle){
            print_r($libelle);
            $req = 'SELECT DISTINCT id FROM categorie WHERE libelle = ' . "'$libelle'";
            //print_r($req);
            $this->db->query($req);
            $result = $this->db->single();
            print_r($result->id);
            //unset($this->db->PDOStatement);
            return $result->id;
           //
        }
        public function addCategory($data){
            
            //$categorie = $this->getCatByName($data['categories']);
            //print_r($data);
            $this->db->query('INSERT INTO categorie (libelle, auteur) VALUES("'.$data['libelle'].'", "'.$data['auteur'].'")');
           
            // Execute
            //unset($this->db->PDOStatement);
            
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function updateCategory($data, $id){
            //$categorie = $this->getCatByName($data['categories']);
            print_r($data);
            $this->db->query('UPDATE categorie SET libelle = "'.$data['libelle'].'" where id = '.$id.'.');
            
            // Execute
            if($this->db->execute()){
              return true;
            } else {
              return false;
            }
          }
          public function deleteCategory($libelle){
            $this->db->query('DELETE FROM categorie WHERE libelle = "'.$libelle.'"');
            // Execute
            if($this->db->execute()){
              return true;
            } else {
              return false;
            }
          }

        
    }