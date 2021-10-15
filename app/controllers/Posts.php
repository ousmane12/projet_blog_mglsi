<?php
  class Posts extends Controller {
    public function __construct(){
        if(!isLoggedIn()){
            redirect('pages/index');
            $this->postModel = $this->model('Post');
            //post add
          }
        $this->postModel = $this->model('Post'); 
      }
      public function add(){
        $categories = $this->postModel->getCategories();
        
        //print_r($auteur);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
              'titre' => trim($_POST['titre']),
              'contenu' => trim($_POST['contenu']),
              'categories' => trim($_POST['categories']),
              'auteur' => $_SESSION['user_name']
            ];
    
            // Validate data
            if(empty($data['titre'])){
              $data['title_err'] = 'Please enter title';
            }
            if(empty($data['contenu'])){
              $data['body_err'] = 'Please enter the content of the post';
            }
    
            // Make sure no errors
            if(empty($data['titre_err']) && empty($data['contenu_err'])){
              // Validated
              
              if(!($this->postModel->addPost($data))){
                flash('post_message', 'Post Added');
                redirect('/');
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
          'auteur' => $_SESSION['user_name']
        ];
        
        $this->view('posts/add', $data);
    }
    }

    
    public function edit($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          // Sanitize POST array
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  
          $data = [
            'id' => $id,
            'titre' => trim($_POST['titre']),
            'contenu' => trim($_POST['contenu']),
            'auteur' => $_SESSION['user_name'],
            'categories' => trim($_POST['categories']),
            'title_err' => '',
            'body_err' => ''
          ];
  
          // Validate data
          if(empty($data['titre'])){
            $data['title_err'] = 'Please enter title';
          }
          if(empty($data['contenu'])){
            $data['body_err'] = 'Please enter body text';
          }
  
          // Make sure no errors
          if(empty($data['titre_err']) && empty($data['contenu_err'])){
            // Validated
            if(!($this->postModel->updateArticle($data))){
              flash('post_message', 'Post Updated');
              redirect('pages');
            } else {
              //die('Something went wrong');
              redirect('pages');
            }
          } else {
            // Load view with errors
            $this->view('posts/edit', $data);
          }
  
        } else {
          // Get existing post from model
          $post = $this->postModel->getById($id);
          $categories = $this->postModel->getCategories();
          //print_r($post);
          // Check for owner
        if($post[0]->auteur != $_SESSION['user_name']){
            redirect('pages');
          }
          $data = [
            'id' => $id,
            'titre' => $post[0]->titre,
            'contenu' => $post[0]->contenu,
            'categories' => $categories
          ];
          //print_r($data);
    
          $this->view('posts/edit', $data);
        }
      }

      public function delete($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          // Get existing post from model
          $post = $this->postModel->getByid($id);
          
          // Check for owner
          if($post[0]->auteur != $_SESSION['user_name']){
            redirect('pages');
          }
  
          if($this->postModel->deletePost($id)){
            flash('post_message', 'Post Removed');
            redirect('pages');
          } else {
            die('Something went wrong');
          }
        } else {
          redirect('pages');
        }
      }

      
      
  }