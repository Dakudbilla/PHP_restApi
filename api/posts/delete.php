<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


include_once "../../config/Database.php";
include_once "../../models/Post.php";

//instantiate database and connect

$database  = new Database();
$db = $database->connect();

//instantiate blog post object
$post = new Post($db);

$post->id=isset($_GET['id'])?$_GET['id']:die();




//DELETE Post
if ($post->delete()) {
   echo json_encode(
       array('message'=>"Post DELETED")
   );
} else {
    echo json_encode(
       array('message'=>"Post Not DELETED")
   );
}
