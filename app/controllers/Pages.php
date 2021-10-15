<?php
  class Pages extends Controller {
    public function __construct(){
      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');
      
    }

    public function index(){
        
        $categories = $this->postModel->getCategories();
        $pagination = $this->postModel->getPagination();
        $posts = $pagination['articles'][0];
        //print_r($pagination['articles'][0][0]);
        
        $data = [
            'title' => 'GLSI NEWS BLOG',
            'posts' => $posts,
            'categories' => $categories,
            'pagination' => $pagination['pagination']
        ];
       
        $this->view('pages/index', $data);
    }

    public function navbar(){
        //$posts = $this->postModel->getPost();
        $categories = $this->postModel->getCategories();
        $data = [
            'categories' => $categories
        ];
        //echo $data;
        print_r($data);
       
        $this->view('inc/navbar', $data);
    }

    
    public function categorie(){
        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
           
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_NUMBER_INT);
            //print_r($_GET['url']);
            $categories = $this->postModel->getCategories();
            $category = $this->postModel->getByCategoryId($_GET['url']);
            
            $data = [
                'category' => $category,
                'categories' => $categories
            ];
            //print_r($data['category']['Error']);
            
        }else{
            echo 'Error has occured';
        }
        
        //echo $data;
        $this->view('pages/categorie', $data);
        
        
        
    }

    public function article(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
           
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_NUMBER_INT);
            //print_r($_GET['url']);
            $articleId = $this->postModel->getByid($_GET['url']);
            //print_r($articleId);
            $categories = $this->postModel->getCategories();
            $user = $this->userModel->getUserById($articleId[0]->auteur);
            $data = [
                'categories' => $categories,
                'article' => $articleId,
                'user' => $user
            ];
            
            
        }else{
            echo 'Error has occured';
        }
        
        $this->view('pages/article', $data);
    }

    public function add(){
        $categories = $this->postModel->getCategories();
        $auteur = $_SESSION['user_name'];
        //print_r($auteur);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
              'titre' => trim($_POST['titre']),
              'contenu' => trim($_POST['contenu']),
              'categories' => trim($_POST['categories']),
              'auteur' => $_SESSION['user_id']
            ];
    
            // Validate data
            if(empty($data['title'])){
              $data['title_err'] = 'Please enter title';
            }
            if(empty($data['body'])){
              $data['body_err'] = 'Please enter the content of the post';
            }
    
            // Make sure no errors
            if(empty($data['titre_err']) && empty($data['contenu_err'])){
              // Validated
              if($this->postModel->addPost($data)){
                flash('post_message', 'Post Added');
                redirect('posts');
              } else {
                die('Something went wrong');
              }
            } else {
              // Load view with errors
              $this->view('posts/add', $data);
            }
    
          } else {
        $data = [
          'titre' => '',
          'contenu' => '',
          'categories' => $categories,
          'auteur' => $auteur
        ];
        
        $this->view('posts/add', $data);
    }
    }

    


      
  

  }