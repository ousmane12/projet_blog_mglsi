<?php
  class Users extends Controller {
    public function __construct(){
      $this->userModel = $this->model('User');
      $this->postModel = $this->model('Post');
    }

    public function register(){
      // Check for POST
      $categories = $this->postModel->getCategories();
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data =[
          'nom' => trim($_POST['nom']),
          'prenom' => trim($_POST['prenom']),
          'email' => trim($_POST['email']),
          'username' => trim($_POST['username']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'role' => trim($_POST['role']),
          'token' => trim($_POST['token']),
          'nom_err' => '',
          'email_err' => '',
          'password_err' => '',
          'token_err' => '',
          'confirm_password_err' => ''
        ];
        //print_r($data);

        // Validate Password
        if(empty($data['password'])){
          $data['password_err'] = 'Please enter a token';
        } elseif(strlen($data['password']) < 6){
          $data['password_err'] = 'Password must be at least 6 characters';
        }

        
        // Make sure errors are empty
        if(empty($data['email_err']) && empty($data['nom_err'])){
          // Validated
          
          // Hash Password
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
          print_r($data['password']);
         
          // Register User
          if(!($this->userModel->register($data))){
            flash('register_success', 'User registered and can log in');
            redirect('users/list');
          } else {
            die('Something went wrong');
          }

        } else {
          // Load view with errors
          $this->view('users/register', $data);
        }

      } else {
        // Init data
        $data =[
          'nom' => '',
          'prenom' => '',
          'email' => '',
          'username' => '',
          'password' => '',
          'confirm_password' => '',
          'nom_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => '',
          'categories' => $categories
        ];

        // Load view
        $this->view('users/register', $data);
      }
    }

    public function login(){
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Init data
        $data =[
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'email_err' => '',
          'password_err' => '',      
        ];

        // Validate Email
        if(empty($data['email'])){
          $data['email_err'] = 'Pleae enter email';
        }

        // Validate Password
        if(empty($data['password'])){
          $data['password_err'] = 'Please enter password';
        }

        // Check for user/email
        if($this->userModel->findUserByEmail($data['email'])){
          // User found
        } else {
          // User not found
          $data['email_err'] = 'No user found';
        }

        // Make sure errors are empty
        if(empty($data['email_err']) && empty($data['password_err'])){
          // Validated
          // Check and set logged in user
          $loggedInUser = $this->userModel->login($data['email'], $data['password']);

          if($loggedInUser){
            // Create Session
            $this->createUserSession($loggedInUser);
          } else {
            $data['password_err'] = 'Password incorrect';

            $this->view('users/login', $data);
          }
        } else {
          // Load view with errors
          $this->view('users/login', $data);
        }


      } else {
        // Init data
        $data =[    
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',        
        ];

        // Load view
        $this->view('users/login', $data);
      }
    }

    public function createUserSession($user){
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_email'] = $user->email;
      $_SESSION['user_nom'] = $user->username;
      $_SESSION['user_role'] = $user->role;
      $_SESSION['user_token'] = $user->token;
      redirect('pages');
    }

    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_nom']);
      session_destroy();
      redirect('pages');
    }

    public function isLoggedIn(){
      if(isset($_SESSION['user_id'])){
        return true;
      } else {
        return false;
      }
    }
    public function list(){
      $categories = $this->postModel->getCategories();
      $users = $this->userModel->getList();
      //$posts = $pagination['articles'][0];
        //print_r($pagination['articles'][0][0]);
        
        $data = [
            'users' => $users,
            'categories' => $categories,
            
        ];
       
      $this->view('users/list', $data);
    }

    public function delete($id){
      if($_SERVER['REQUEST_METHOD'] == 'GET'){
        // Get existing post from model
        $this->userModel->getUserById($id);

        if(!($this->userModel->deleteUser($id))){
          flash('post_message', 'User Removed');
          redirect('users/list');
        } else {
          die('Something went wrong');
        }
      } else {
        redirect('pages');
      }
    }
    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Get existing post from model
        
        $data = [
          'id' => $id,
          'nom' => trim($_POST['nom']),
          'prenom' => trim($_POST['prenom']),
          'username' => trim($_POST['username']),
          'password' => trim($_POST['password']),
          'role' => trim($_POST['role']),
          'token' => trim($_POST['token']),
          
        ];
        //print_r($data);
        
        if(!($this->userModel->updateUser($data))){
          flash('post_message', 'User edited');
          redirect('users/list');
        } else {
          die('Something went wrong');
        }
      } else {
        //print_r($id);
        $user = $this->userModel->getUserById($id);
        //print_r($user);
        $data = [
          'id' => $id,
          'nom' => $user->nom,
          'prenom' => $user->prenom,
          'email' => $user->email,
          'username' => $user->username,
          'password' => $user->password,
          'role' => $user->role,
          'token' => $user->token,
          
        ];
        //print_r($data);
        $this->view('users/edit', $data);
      }

    }
  }