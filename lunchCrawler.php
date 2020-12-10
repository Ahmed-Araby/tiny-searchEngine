<?php 
require_once "classes/crawler.php";

$fileName = "files/seed.txt";
crawler::crawle($fileName, 1, 1, 100);

?>