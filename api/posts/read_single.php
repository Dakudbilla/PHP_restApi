<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once "../../config/Database.php";
include_once "../../models/Post.php";

//instantiate database and connect

$database  = new Database();
$db = $database->connect();

//instantiate blog post object
$post = new Post($db);

//Get ID
$post->id=isset($_GET['id'])?$_GET['id']:die();

//Get single post by id
$post->read_single();

//create array
if ($post->title!=null) {
    $post_arr=array(
            'id'=>$post->id,
            'title'=>$post->title,
            'body'=>html_entity_decode($post->body),
            'author'=>$post->author,
            'created_at'=>$post->created_at,
            'category_id'=>$post->category_id,
            'category_name'=>$post->category_name
        );
}else {
    $post_arr=  array('message' => 'No Post Found' );

}
 

//make json
print_r(json_encode($post_arr));