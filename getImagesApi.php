<?php
    require_once "Controllers/imagesController.php";

    	if(isset($_GET["term"])) {
		$term = $_GET["term"];
	}
	else {
		exit("You must enter a search term");
	}
	
    $type = isset($_GET["type"]) ? $_GET["type"] : "sites";
    $requestNumber = isset($_GET['reqNum'])?$_GET['reqNum']:1;
    
    if($type !='images' || 
        $requestNumber < 2)
        die("you are not allowed to request this page");
    
    $imageControllerObj  = new imagesController();
    $images = $imageControllerObj->getImagesResult($term, $requestNumber);
    echo  json_encode($images);