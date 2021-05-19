
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once "../../config/Database.php";
include_once "../../models/Post.php";
include_once "../../models/Category.php";


//instantiate database and connect

$database  = new Database();
$db = $database->connect();

//instantiate blog post object
$post = new Post($db);


//Get ID
$post->category_id=isset($_GET['id'])?$_GET['id']:die();
//Blog post query
$result=$post->category_posts();


//get row count
$num_rows= $result->rowCount();

//check if posts
if ($num_rows>0) {
    //posts array
    $posts_arr=array();
    $posts_arr['data']= array();

    //create new category to return the name of the category
    $category = new Category($db); 
    //Get ID
    $category->id=isset($_GET['id'])?$_GET['id']:die();

    //call read single
    $category_result=$category->read_single();

    $posts_arr["category_name"]=$category->name;

foreach( $result->fetch(PDO::FETCH_ASSOC) as $row){
 //makes the variables in row available
        extract($row);
        $post_item=array(
           'id'=>$id,
            'title'=>$title,
            'body'=>html_entity_decode($body),
            
        );

        //push array to "data"
        array_push($posts_arr["data"],$post_item);
}



    //turn response to JSON and output
    echo json_encode($posts_arr);
}else {

    //Create new Category
    $category = new Category($db); 
    //Get ID
    $category->id=isset($_GET['id'])?$_GET['id']:die();
    //call read single
    $result=$category->read_single();

    //NO posts available
    echo json_encode(
 array('category_name' => $category->name,"message"=>"No Posts for ".$category->name )    );

}
?>