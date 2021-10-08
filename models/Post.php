<?php
    class Post
    {
        //DB variables
        private $conn; 
        private $table = 'article';

        // Properties
        public $id;
        public $titre;
        public $category_name;
        public $contenu;
        public $body;
        public $dateCreation;
        public $dateModification;
        public $auteur;
        public $categories;
       
        //Constructor Db
        public function __construct($db){
            $this->conn = $db; 
        }
        
        // Get posts
        public function read(){
            //Query
            $query = 'SELECT c.libelle as category_name,
            p.id,
            p.titre,
            p.contenu,
            p.dateCreation,
            p.dateModification,
            p.auteur
           FROM 
            ' . $this->table . ' p 
            LEFT JOIN categorie c on p.categorie = c.id
            ORDER BY p.dateCreation DESC';
            //$query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
            //                    FROM ' . $this->table . ' p
             //                   LEFT JOIN
             //                     categories c ON p.category_id = c.id
             //                   ORDER BY
              //                    p.created_at DESC';
            //$req = 'SELECT * FROM article order by dateModification';

            //prepare statement 
            $stmt = $this->conn->prepare($query);
            //Execute it 
            $stmt->execute();
            return $stmt;
        }

        //get single post
        public function read_single(){
            $query = 'SELECT c.libelle as category_name,
            p.id,
            p.titre,
            p.contenu,
            p.dateCreation,
            p.dateModification,
            p.auteur
           FROM 
            ' . $this->table . ' p 
            LEFT JOIN categorie c on p.categorie = c.id
            WHERE 
             p.id = ?
            LIMIT 0,1';

             //prepare statement 
             $stmt = $this->conn->prepare($query);

             //BIND the ID
             $stmt->bindParam(1, $this->id);
             //Execute it 
             $stmt->execute();
             $row = $stmt->fetch(PDO::FETCH_ASSOC);

             //Set properties
             $this->titre = $row['titre'];
             $this->contenu = $row['contenu'];
             $this->dateCreation = $row['dateCreation'];
             $this->category_name = $row['category_name'];
             $this->dateModification = $row['dateModification'];
             $this->auteur = $row['auteur'];
             return $stmt;
        }

        
        //Read all post by category
        public function read_by_cat(){
            //Query 
            $req = 'SELECT a.id, a.titre, a.contenu, a.dateCreation, a.dateModification, a.auteur, a.categorie, c.libelle as category_name
            FROM '.$this->table.' a inner join categorie c on a.categorie = c.id where c.libelle = ?;
            ';

            // prepare query
             //prepare statement 
             $stmt = $this->conn->prepare($req);

             //BIND the ID
             $stmt->bindParam(1, $this->libelle);
             //Execute it 
             $stmt->execute();
             //prepare statement 
             
             
             return $stmt;
        
        }

        //read by category using all categories
        public function regroupCategories()
        {
            $req = 'SELECT distinct(libelle) FROM categorie';
            $stmt = $this->conn->prepare($req);

            $stmt->execute();
            $result = $stmt->fetchall(PDO::FETCH_ASSOC);
            foreach ($result as $libelle => $value) {
                $this->categories[$value['libelle']] = array();
            }
            return $this->categories;

        }
        public function regroupArticles(){
            foreach ($this->categories as $c => $value) {
                $req = 'SELECT a.id, a.titre, a.contenu, a.dateCreation, a.dateModification, a.auteur, a.categorie, c.libelle as category_name
                FROM '.$this->table.' a inner join categorie c on a.categorie = c.id where c.libelle = "'. $c .'"';
                $stmt = $this->conn->prepare($req);
                $stmt->execute();
                $result = $stmt->fetchall(PDO::FETCH_ASSOC);
                array_push($this->categories[$c],$result);
            }
            
            return $this->categories;
           
        }
    }
    