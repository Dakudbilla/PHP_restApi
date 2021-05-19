<?php
header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');
header('Access-Control-Allow-Methods:  GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once "../../config/Database.php";
include_once "../../models/Post.php";

//instantiate database and connect

$database  = new Database();
$db = $database->connect();

//instantiate blog post object
$post = new Post($db);

//Blog post query
$result=$post->read();

//get row count
$num_rows= $result->rowCount();

//check if posts
if ($num_rows>0) {
    //post array
    $posts_arr=array();
    $posts_arr['data']= array();

    //loop through results
    while ($row=$result->fetch(PDO::FETCH_ASSOC)) {
        //makes the variables in row available
        extract($row);
        $post_item=array(
            'id'=>$id,
            'title'=>$title,
            'body'=>html_entity_decode($body),
             'author'=>$author,
             'created_at'=>$created_at,
            'category_id'=>$category_id,
            'category_name'=>$category_name
        );

        //push array to "data"
        array_push($posts_arr["data"],$post_item);
    }

    //turn response to JSON and output
    echo json_encode($posts_arr);
}else {

    //NO posts available
    echo json_encode(
 array('message' => 'No Posts Found' )    );

}
?>