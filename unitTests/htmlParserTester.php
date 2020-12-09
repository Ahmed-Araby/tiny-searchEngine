<?php 

require_once "HELPERS.php";
require_once "classes/httpRequester.php";
require_once "classes/htmlParser.php";

class htmlParserTester
{
    public function __construct()
    {
        newLine();
        echo "htmlParserTester is initiated";
        newLine();
    }

    private  static function test_parsingAnchorsHrefs()
    {
        // requesting
        $url = "http://localhost/doddle_Search_Engine/links.php";
        $response = httpRequester::request($url);
        $htmlBody = $response['body'];

        // parsing
        $parseInfo = htmlPasrer::parse($htmlBody);
        $hrefs = $parseInfo['anchorHrefs'];
        var_dump($hrefs);
        return ;
    }

    private static function test_parsingImageSrcs()
    {
        // requesting
        $url = "http://localhost/doddle_Search_Engine/links.php";
        $response = httpRequester::request($url);
        $htmlBody = $response['body'];

        // parsing
        $parseInfo = htmlPasrer::parse($htmlBody);
        $imgSrcs = $parseInfo['imgSrcs'];
        var_dump($imgSrcs);
        return ;
    }

    private static function test_parsingMetaData()
    {
        // requesting
        $url = "http://localhost/doddle_Search_Engine/links.php";
        $response = httpRequester::request($url);
        $htmlBody = $response['body'];

        // parsing
        $parseInfo = htmlPasrer::parse($htmlBody);
        $metaData = $parseInfo['metaData'];

        var_dump($metaData);
        return ;
    }

    public static function runTests()
    {
        self::test_parsingAnchorsHrefs();

        self::test_parsingImageSrcs();

        self::test_parsingMetaData();
        
        newLine();
        echo "finishing testing html parser ";
        newLine();
    }

}


htmlParserTester::runTests();

?>