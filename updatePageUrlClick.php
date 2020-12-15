<?php 

require_once "Controllers/udpatePageUrlClickController.php";

$json = file_get_contents('php://input');
if($json != false)
{
    // there is no json data 
    header("Content-Type", "application/json");
    /**
    * true == reutrn as associative array 
    * if we ignore it then it will return object
    * which mean we will need to access data using ->
    */

    $data = json_decode($json, true);
    $id = $data['pageUrlId'];

    $pagesModelObj = new udpatePageUrlClickController();
    $success = $pagesModelObj->increasePageUrlClicks($id);

    if(!$success)
        echo json_encode("server failure, could not update clicks");
    else 
        echo json_encode("success");
}

else {
    header("Content-Type", "application/json");
    echo json_encode("failure,  server can't read the incomming data");
}