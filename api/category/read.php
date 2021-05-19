<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once "../../config/Database.php";
include_once "../../models/Category.php";

//instantiate database and connect

$database  = new Database();
$db = $database->connect();

//instantiate blog post object
$category = new Category($db);

//Blog post query
$result=$category->read();

//get row count
$num_rows= $result->rowCount();

//check if posts
if ($num_rows>0) {
    //post array
    $category_arr=array();
    $category_arr['data']= array();

    //loop through results
    while ($row=$result->fetch(PDO::FETCH_ASSOC)) {
        //makes the variables in row available
        extract($row);
        $category_item=array(
            'id'=>$id,
            'name'=>$name,
            
        );

        //push array to "data"
        array_push($category_arr["data"],$category_item);
    }

    //turn response to JSON and output
    echo json_encode($category_arr);
}else {

    //NO Categories available
    echo json_encode(
 array('message' => 'No Categories Found' )    );

}
?>