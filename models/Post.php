<?php
class Post
{
    //DB connection variable
    private $conn;
    //Post table variable
    private $table="posts";

    //Post properties
    public $id;
    public $category_id;
    public $category_name;
    public $title; 
    public $body;
    public $author;
    public $created_at;

    //constructor to connect to DB when object
    //is created
    public function __construct($db)
    {
        $this->conn=$db;

    }

    //Get Posts
    public function read()
    {
        //sql query to read all posts from DB
        $query ='SELECT 
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                    FROM
                    '.$this->table.' p
                    LEFT JOIN
                        categories c on p.category_id=c.id

                    ORDER BY
                        p.created_at ASC';

        //prepare PDO statement 
        $stmt  = $this->conn->prepare($query);
        //execute query
        $stmt->execute();

        return $stmt;
    }

    //Get all Post from the same Category
    public function category_posts()
    {
       //sql query to read all posts from DB
        $query ='SELECT 
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                    FROM
                    '.$this->table.' p
                    WHERE 
                        p.category_id=?
                        
                  ';
                   

        //prepare PDO statement 
        $stmt  = $this->conn->prepare($query);
        //Bind ID
        $stmt->bindParam(1,$this->category_id);

        //execute query
        $stmt->execute();

       $row = $stmt->fetch(PDO::FETCH_ASSOC);

       //Set Properties
       if ($row) {
            $this->title=$row['title'];
            $this->body=$row['body'];
            $this->author=$row['author'];
            
       }
       
       return $stmt;
    }

    
    //Get single Post
    public function read_single()
    {
       //sql query to read all posts from DB
        $query ='SELECT 
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                    FROM
                    '.$this->table.'  p
                    LEFT JOIN
                        categories c on p.category_id=c.id
                    WHERE 
                        p.id=?
                    LIMIT 0,1';

        //prepare PDO statement 
        $stmt  = $this->conn->prepare($query);
        //Bind ID
        $stmt->bindParam(1,$this->id);
        //execute query
        $stmt->execute();

       $row = $stmt->fetch(PDO::FETCH_ASSOC);

       //Set Properties
       if ($row) {
            $this->title=$row['title'];
            $this->body=$row['body'];
            $this->author=$row['author'];
            $this->created_at=$row['created_at'];
            $this->category_id=$row['category_id'];
            $this->category_name=$row['category_name'];
       }
       

    }

   


    //create Post
    public function create()
    {
        //create query
        $query ='INSERT INTO '.$this->table.'
            SET
            title=:title,
            body=:body,
            author=:author,
            category_id=:category_id';

            //Prepare Statement
            $stmt= $this->conn->prepare($query);

            //clean data
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->body=htmlspecialchars(strip_tags($this->body));
            $this->author=htmlspecialchars(strip_tags($this->author));
            $this->category_id=htmlspecialchars(strip_tags($this->category_id));

            //Bind data
            $stmt->bindParam(':title',$this->title);
            $stmt->bindParam(':body',$this->body);
            $stmt->bindParam(':author',$this->author);
            $stmt->bindParam(':category_id',$this->category_id);

            //Execute Query
            if ($stmt->execute()) {
                return true;
            }

            //Print Error if something goes wrong
            printf("Error: %s.\n",$stmt->error);

            return false;
    }

     //Update Post
    public function update()
    {
        //create query
        $query ='UPDATE '.$this->table.'
            SET
                title=:title,
                body=:body,
                author=:author,
                category_id=:category_id
            WHERE 
                id=:id';

            //Prepare Statement
            $stmt= $this->conn->prepare($query);

            //clean data
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->body=htmlspecialchars(strip_tags($this->body));
            $this->author=htmlspecialchars(strip_tags($this->author));
            $this->category_id=htmlspecialchars(strip_tags($this->category_id));
            $this->id=htmlspecialchars(strip_tags($this->id));

            //Bind data
            $stmt->bindParam(':title',$this->title);
            $stmt->bindParam(':body',$this->body);
            $stmt->bindParam(':author',$this->author);
            $stmt->bindParam(':category_id',$this->category_id);
            $stmt->bindParam(':id',$this->id);

            //Execute Query
            if ($stmt->execute()) {
                return true;
            }

            //Print Error if something goes wrong
            printf("Error: %s.\n",$stmt->error);

            return false;
    }

    //Delete Post
    public function delete()
    {
        $query = 'DELETE FROM '.$this->table.' WHERE id=:id';
        
        //Prepare Statement
        $stmt= $this->conn->prepare($query);

        //clean data
        $this->id=htmlspecialchars(strip_tags($this->id));

        //Bind Data
         $stmt->bindParam(':id',$this->id);

        //Execute Query
        if ($stmt->execute()) {
                return true;
        }

        //Print Error if something goes wrong
        printf("Error: %s.\n",$stmt->error);

        return false;
    }

    
}

?>