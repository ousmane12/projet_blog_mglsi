<?php
  /*
   * PDO Database Class
   * Connect to database
   * Create prepared statements
   * Bind values
   * Return rows and results
   */
  class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
      // Set DSN
      $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
      $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );

      // Create PDO instance
      try{
        $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
      } catch(PDOException $e){
        $this->error = $e->getMessage();
        echo $this->error;
      }
    }
    //prepare query function
    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);
        //print_r($this->stmt);
    }

    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;    
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
        //unset($this->stmt);
    }

    //execute the prepared stmt
    public function execute(){
        $this->stmt->execute();
    }

    //get result as array obkect
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //get single record
    public function single(){
        $this->execute();
        unset($this->PDOStatement);
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    //get row count
    public function rowCount(){
        return $this->stmt->rowCount();
    }

    public function executer($req){
      return $this->stmt->execute($req);
    }
  }