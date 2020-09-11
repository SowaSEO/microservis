<?php
class User{
    
    private $conn;
    private $table_name = "users";
      
    public $id;
    public $first_name;
    public $last_name;
    public $login;
    public $password;
          
    public function __construct($db){ 
        
        $this->conn = $db;
    }
          
    function read_one(){

        $query = "SELECT
                    id, first_name, last_name, login, password 
                FROM
                    " . $this->table_name . "
                WHERE            
                    id = :id";  
        
        $stmt = $this->conn->prepare( $query );
        
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                
        $stmt->execute();
                
        $row = $stmt ->fetch(PDO::FETCH_ASSOC);
        
        
        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->login = $row['login'];
        $this->password = $row['password'];
                   
        return $stmt;        
    }                   
    
   function read_all($from, $qrecords){
        $query = "SELECT
                    id, first_name, last_name, login, password  
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id ASC
                LIMIT
                    {$from}, {$qrecords}";
             
        $stmt = $this->conn->prepare( $query );
        
        var_dump($stmt);
        
        $stmt->execute();
        
        $datares = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $datares;
    }
                
    function add(){          
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    first_name=:first_name, last_name=:last_name, 
                    login=:login, password=:password";
        
        $stmt = $this->conn->prepare($query);
  
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->login=htmlspecialchars(strip_tags($this->login));
        $this->password=htmlspecialchars(strip_tags($this->password));
                  
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":login", $this->login);
        $stmt->bindParam(":password", $this->password);        
  
        if($stmt->execute()){
            
            $this->id= $this->conn->lastInsertId();
            
            return true;
        }else{
            return false;
        }
  
    }
        
    function update(){
  
        $query = "UPDATE
                " . $this->table_name . "
            SET
                    first_name=:first_name, last_name=:last_name, 
                    login=:login, password=:password
            WHERE
                id = :id";                            
        
        $stmt = $this->conn->prepare($query);
          
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->login=htmlspecialchars(strip_tags($this->login));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->id=htmlspecialchars(strip_tags($this->id));        
                  
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":login", $this->login);
        $stmt->bindParam(":password", $this->password);        
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
  
        if($stmt->execute()){
            return true;
        }

        return false;

    }
    
    function delete(){
  
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);

        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }  
}
?>
