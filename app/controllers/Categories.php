<?php
  class Categories extends Controller {
    public function __construct(){
        if(!isLoggedIn()){
            redirect('pages/index');
            $this->categoryModel = $this->model('Category');
            //post add
          }
        $this->categoryModel = $this->model('Category'); 
      }
      public function add(){
        $categories = $this->categoryModel->getCategories();
        //print_r($auteur);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST array
            
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
              'libelle' => trim($_POST['libelle']),
              'auteur' => $_SESSION['user_name']
            ];
            print_r($data);
    
            // Validate data
            if(empty($data['libelle'])){
              $data['libelle_err'] = 'Please enter title';
            }
    
            // Make sure no errors
            if(empty($data['libelle_err'])){
              // Validated
              
              if(!($this->categoryModel->addCategory($data))){
                flash('post_message', 'Category Added');
                redirect('/');
              } else {
                die('Something went wrong');
              }
            } else {
              // Load view with errors
              $this->view('categories/add', $data);
            }
    
          } else {
        $data = [
          'libelle' => '',
          'auteur' => $_SESSION['user_name'],
          'categories' => $categories
        ];
        
        $this->view('categories/add', $data);
    }
    }

    
    public function edit(){
        
          $data = [
            
            'categories' => trim($_POST['categories']),
            'libelle' => trim($_POST['libelle']),
            
          ];

          //print_r($data);
          $id = $this->categoryModel->getCatByName($data['categories']);
          print_r($id);
  
          // Validate data
          if(empty($data['libelle'])){
            $data['title_err'] = 'Please enter label';
          }
          if(empty($data['categories'])){
            $data['categories_err'] = 'Please select categorie';
          }
  
          // Make sure no errors
          if(empty($data['libelle_err']) && empty($data['categories_err'])){
            // Validated
            if(!($this->categoryModel->updateCategory($data, $id))){
              flash('post_message', 'Category Updated');
              redirect('pages');
            } else {
              die('Something went wrong');
              
            }
          } else {
            // Load view with errors
            $this->view('categories/edit', $data);
          }
  
          $this->view('categories/edit', $data);
        
      }

      public function load(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
          // Sanitize POST array
          
          //$post = $this->categoryModel->getCategories();
          $categories = $this->categoryModel->getCategories();
          $data = [
            'id' =>'',
            'categories' => $categories,
            'libelle' => ''
            
          ];
          $this->view('categories/edit', $data);
        }else{
            $data = [
                
                'categories' => trim($_POST['categories']),
                'libelle' => trim($_POST['libelle'])
              ];
              //print_r($data);
           
            // Validated
            //print_r($id);
            $this->edit();
            $this->view('categories/edit', $data);
        }
      }

      public function delete(){
        $auteur = $_SESSION['user_name'];
        $userCategory = $this->categoryModel->getCatByUser("'.$auteur.'");
        $categories = $this->categoryModel->getCategories();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          // Get existing post from model
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          $data = [
            
            'libelle' => trim($_POST['libelle']),
            'auteur' => $_SESSION['user_name'],
            
          ];
          //$post = $this->categoryModel->getCatByid($_POST);
          
         
  
          if(!($this->categoryModel->deleteCategory($data['libelle']))){
              print_r($data['libelle']);
            flash('post_message', 'Category Removed');
            redirect('pages');
          } else {
            die('Something went wrong');
          }
        } else {
            $data = [
                'libelle' => '',
                'categories' => $categories,
                'user' => $userCategory
              ];
              //print_r($data);
        
              $this->view('categories/delete', $data);
        }
      }

      
      
  }