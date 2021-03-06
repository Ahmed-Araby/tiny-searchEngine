<?php


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


/*
// tets curl function 
// test reedirection using curl
// test code status 
// test type of returned information 

$url = "https://www.php.net/manual/en";
$curl = curl_init();
curl_setopt_array($curl,
    array(
        CURLOPT_URL => $url, 
        CURLOPT_HEADER => false,  // dont return the headers in the response. 
        CURLOPT_RETURNTRANSFER => true   // prevent the extension from printing the response. 
    )
);

$data = curl_exec($curl);
$headersSize  = curl_getinfo($curl, CURLINFO_HEADER_SIZE );
$headers = substr($data, 0, $headersSize);
var_dump($headers);
newLine();
newLine();

$statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
$contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

echo "status code " . $statusCode;
newLine();
echo "content type -- $contentType";
newLine();
echo "header size -- $headersSize";
newLine();
newLine();

echo "additional info : " . curl_getinfo($curl, CURLINFO_REDIRECT_URL);
newLine();
echo gettype($statusCode);
newLine();
$arr = explode(";", $contentType);
var_dump($arr);
newLine();

$contentType = null;
echo gettype($contentType);
newLine();
$contentType = explode(';', $contentType)[0];
$contentType = strtolower($contentType);
echo "type -- " . $contentType;
newLine();
var_dump(explode('1', null));
newLine();
*/

/*
// testing fille open 
require_once "HELPERS.php";

$fileName = "seeds.txt";
$filePtr = fopen($fileName, "r");
newLine();
if($filePtr ===  false)
    echo "failed";
newLine();

echo "some stuff";
*/

/*
// test empty array 
$arr = array();
if($arr.empty == true)
    echo "empty";
*/

/*
// test exception message 
try{
    throw new Exception("execption here ");
}
catch(Exception $e){
    echo $e->getMessage();
}

*/


require_once "pdoFactory.php";
// test utf8 encoding 
/*
this one succeded in inserting the arabic chars in the right encoding
$v = "احمد عربى " ;
echo $v;
echo "\n";

$pdo = pdoFactory::getPdoInstance();
$query = "insert into pages values (2, 'ahmed', 0, ? , ? , ?)";
$stmt = $pdo->prepare($query);

$stmt->bindValue(1, " بسم ");
$stmt->bindValue(2, "الله ");
$stmt->bindValue(3, "الرحمن");
$success = $stmt->execute();

var_dump($success);
*/

require_once "classes/httpRequester.php";
require_once "classes/htmlParser.php";

$url = "https://mawdoo3.com/";
$response = httpRequester::request($url);
$htmlBody = $response['body'];
$htmlInfo = htmlPasrer::parse($htmlBody);

//var_dump($response);
$text = $htmlInfo['anchorHrefs'][9];

$pdo = pdoFactory::getPdoInstance();
$query = "insert into pages values (4, 'ah32me23d', 0, ? , ? , ?)";
$stmt = $pdo->prepare($query);

$stmt->bindValue(1, " بسم ");
$stmt->bindValue(2, "الله ");
$stmt->bindValue(3, $text);
$success = $stmt->execute();
//newLine();
?>
