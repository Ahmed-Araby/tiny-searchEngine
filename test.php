<?php

function newLine()
{
    echo "\n";
}

/*
// test the substr_replace function
$href = "../../../index.html";
$href = substr_replace($href, "", 0, 3);
echo $href;
newLine();
echo strlen($href)
*/

/*
// test throw exception

$url = "1";
$href = "2";
$result = "3";
$absUrl = "4";

newLine();
echo "start";
newLine();
throw new Exception("no Match: $url,  $href,  $result,  $absUrl");

newLine();
echo "end";
*/

/*
// test dirname function 
$url = "https://www.php.net/manual/en/index.html";
$path = parse_url($url)["path"];

newLine();
echo "path is " . $path;
newLine();

newLine();
echo "level 1 dir " . dirname($path);
newLine();

newLine();
echo "level 2 dir " . dirname(dirname($path));
newLine();

newLine();
echo "level 3 dir " . dirname(dirname(dirname($path)));
newLine();


newLine();
$l3Path = "level 3 dir " . dirname(dirname(dirname($path)));
echo "l4 path dir " . dirname($l3Path);
newLine();

newLine();
echo "l5 path dir " . dirname(".");
newLine();

*/

?>
