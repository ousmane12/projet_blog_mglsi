<?php

    /**
     * @OA\Info(
     *   title="My first API",
     *   version="1.0.0",
     *   @OA\Contact(
     *     email="support@example.com"
     *   )
     * )
     */

     

    class Post
    {
        //DB variables
        private $conn; 
        private $table = 'article';


        public $format;
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

        /**  @OA\Get(
            *     path="/public/index?action={articles}&{type}", tags ={"article"}
            *     @OA\Response(response="200", description="success")
            *     @OA\Response(response="404", description="Error")
            *     @OA\Info (Liste tous les articles)
            * )
            */
        
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
         /**  @OA\Get(
            *     path="/public/index?action={article}&{id}&{type}", tags ={"public"}
            *     @OA\Response(response="200", description="success")
            *     @OA\Response(response="404", description="Error")
            *     @OA\Info (lis un article selon son id)
            * )
            */
        public function read_single($id){
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
             p.id = '.$id.'
            LIMIT 0,1';

             //prepare statement 
             $stmt = $this->conn->prepare($query);

             
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
         /**  @OA\Get(
            *     path="/public/index?action={articlescategorie}&{type:xml/json}", tags ={"public"}
            *     @OA\Response(response="200", description="success")
            *     @OA\Response(response="404", description="Error")
            *     @OA\Info read article by their categorie
            * )
            */
        public function read_by_cat($libelle){
            //Query 
            $req = 'SELECT a.id, a.titre, a.contenu, a.dateCreation, a.dateModification, a.auteur, a.categorie, c.libelle as category_name
            FROM '.$this->table.' a inner join categorie c on a.categorie = c.id where c.libelle = "'.$libelle.'";
            ';

            // prepare query
             //prepare statement 
             $stmt = $this->conn->prepare($req);

            
             //Execute it 
             $stmt->execute();
             //prepare statement 
             return $stmt;
        
        }

        /**  @OA\Get(
            *     path="/public/index?action=articlesByCategory&type={type:xml/json}", tags ={"article"}
            *     @OA\Response(response="200", description="success")
            *     @OA\Response(response="404", description="Error")
            *     @OA\Info read all articles grouping them by their category
            * )
            */
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
        /**  @OA\Get(
            *     path="/public/index?action={articlesByCategory}&{type:xml/json}", tags ={"public"}
            *     @OA\Response(response="200", description="success")
            *     @OA\Response(response="404", description="Error")
            *     @OA\Info read all articles grouping them by their category
            * )
            */
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
    