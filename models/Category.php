<?php
class Category
{
    //DB connection variables
    private $conn;
    private $table="categories";

    //categories properties
    public $id;
    public $name;    
    public $created_at;

    //constructor to connect to DB when object
    //is created
    public function __construct($db)
    {
        $this->conn=$db;

    }

    //Get Categories
    public function read(){
        //create query
        $query ='SELECT id,name,created_at FROM 
            '.$this->table.'
            ORDER BY 
            created_at DESC';

        //prepare Statement
        $stmt=$this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    //read single Category
    public function read_single(){
        //create query
        $query ='SELECT * FROM 
            '.$this->table.' c
            WHERE c.id=?';
            
        //prepare Statement
        $stmt=$this->conn->prepare($query);
         //Bind ID
        $stmt->bindParam(1,$this->id);
        //execute query
        $stmt->execute();

       
       $row = $stmt->fetch(PDO::FETCH_ASSOC);

       //Set Properties
       if ($row) {
            $this->id=$row['id'];
            $this->name=$row['name'];
            $this->created_at=$row['created_at'];
            
       }
    }

    
}