<?php

require_once('../Persistance/Database.php');
require_once('../domaine/User.php');

class UserController{
    

    public function UserController(){
        //recupération du nom de l'application
        $self = $_SERVER["PHP_SELF"];
        $add = explode("/", $self);

        //Adresse web de l'application
        $this->adresse = "http://". $_SERVER["HTTP_HOST"]. "/".$add[1]."/";
    }

/**
 * add user 
 */
    public function addUser($nom,$prenom,$username,$password,$email,$role)
    {
        $bdd = new Database('localhost','3306', 'glsi_blog', 'root', '');
         $bdd->connect();
         
         $token = $this->generateRandomString();
 

        $request = $bdd->prepare('INSERT INTO user (nom, prenom,
        email,username, password,role, token) VALUES(:nom, :prenom, :email,:username, :password, :role, :token)');

        return $request->execute([
            'nom'    => $nom,
            'prenom' => $prenom,
            'email'   => $email,
            'username'   => $username,
            'password'   => md5(sha1(str_rot13($password))),
            'role' => $role,
            'token' => $token
        ]);
    }

    /**
     * Generate token key
     */

    public function generateRandomString()
    {
        $randomString = [];
        $str = str_split('0123456789abcddefghijklmnopqrstuvwxyz@_-ABCCDEFGHIJKLMNOPQRSTUVWXYZ');
        $length = rand(10,65);
        for($i = 0; $i < $length; $i++)
        {
            $randomString [] = $str[rand(0,64)];
        }
        return implode('', $randomString);
    }
   /**
    *Remove user 
     */ 

    public function removeUser($id)
    {
        $bdd = new Database('localhost','3306', 'glsi_blog', 'root', '');
        $bdd->connect();
         return $bdd->exec('DELETE FROM User WHERE id = '. $id);
    }

    /**
     * get all users
     */
    public function getAllUserList()
    {
        $bdd = new Database('localhost','3306', 'glsi_blog', 'root', '');
         $bdd->connect();
        $users = array();
        
        $request = $bdd->query('SELECT * FROM user');

        while($data = $request->fetch(PDO::FETCH_ASSOC))
        {
            $users [] = $data;
        }

        return $users;
    }

    /**
     * Get user by id
     */
    public function getUserById($id)
    {
        $bdd = new Database('localhost','3306', 'glsi_blog', 'root', '');
        $bdd->connect();
        $id = (int) $id;

        $request = $bdd->query('SELECT * FROM User WHERE id = '.$id);
        $data = $request->fetch(PDO::FETCH_ASSOC);

        $user = ($data === false) ? null : new User($data);
        return $user;
    }

    /**
     * Get user by email
     */
    public function getUserByEmail($email)
    {
        $bdd = new Database('localhost','3306', 'glsi_blog', 'root', '');
        $bdd->connect();
        $request = $bdd->query('SELECT * FROM user WHERE email =  "'.$email.'"');
        $data = $request->fetch(PDO::FETCH_ASSOC);

        $user = ($data === false) ? null : new User($data);
        return $user;
    }
    /**
     * update user info
     */

    public function updateUser($id,$nom,$prenom,$username,$password,$email,$role)
    {
        $bdd = new Database('localhost','3306', 'glsi_blog', 'root', '');
        $bdd->connect();

        $id = (int) $id;
        $request = $bdd ->prepare('UPDATE user SET nom = :nom, prenom = :prenom, username =:username,
                         email = :email, password =:password, role =:role WHERE id = :id');

        return $request->execute([
            'nom'    => $nom,
            'prenom' => $prenom,
            'username'   => $username,
            'email'   => $email,
            'password'   => md5(sha1(str_rot13($password))),
            'role' => $role,
            'id' => $id
        ]);
    }

    public function authenticateUser($useranme, $password)
    {
        $bdd = new Database('localhost','3306', 'glsi_blog', 'root', '');
        $bdd->connect();

        $request = $bdd->prepare('SELECT * FROM user WHERE username = :username and password = :password');
        $request->execute([
            'username' => $useranme,
            'password'   => md5(sha1(str_rot13($password)))
        ]);
        
        return new User($request->fetch(PDO::FETCH_ASSOC));
    }



}

ini_set('soap.wsdl_cache_enabled', 0);
$serversoap = new SoapServer("http://localhost/projet_blog_mglsi/soapService/persistance/wsdl/user.wsdl");

$serversoap->setClass("UserController");

$serversoap->handle();

