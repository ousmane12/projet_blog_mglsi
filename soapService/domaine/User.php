<?php
/**
 * 
 * @author @aristide
 * @since 14/10/21
 * @version 1.0.0
 * 
 */

/**
 * 
 * Class  User.
 */
class User 
{

    private $id;
    
    /**
     *
     * @var String
     */
    private $nom;
    
    /**
     *
     * @var String
     */
    private $prenom;
    
    /**
     *
     * @var String
     */
    private $email;

      /**
     *
     * @var String
     */
    private $username;
    
    /**
     *
     * @var String
     */
    private $role;

      /**
     *
     * @var String
     */
    private $password;
    /**
     *
     * @var String
     */
    private $token;

    public function __construct()
    {
        
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }
}