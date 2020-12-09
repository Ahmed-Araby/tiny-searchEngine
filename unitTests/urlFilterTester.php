<?php 

require_once "HELPERS.php";
require_once "classes/urlFilter.php";
require_once "classes/httpRequester.php";
require_once "classes/htmlParser.php";
require_once "classes/urlResolver.php";

class urlFilterTester
{
    public function __construct()
    {
    }

    public static function test_javaScriptLink1()
    {
        $url = "javascript:someFunction()";
        $valid = urlFilter::filter($url);
        newLine();
    
        if ($valid !== false)
            throw new Exception("test_JavaScriptLink1  -- failed");
    
        echo "test_javaScriptLink1 -- succeed";
        newLine();

        return ;
    }

    public static function test_javaScriptLink2()
    {
        // request
        $url = "http://localhost/doddle_Search_Engine/links.php";
        $response = httpRequester::request($url);
        $body = $response['body'];

        // parse
        $parseInfo = htmlPasrer::parse($body);
        $hrefs = $parseInfo['anchorHrefs'];
        
        foreach($hrefs as $href)
        {
            //$absHref = urlResolver::resolve($url, $href);
            $valid = urlFilter::filter($href);

            newLine();
            echo "href: $href \n"
            . ($valid === true?"valid ": "in valid");
            newLine();
        }

        return ;
    }

    public static function test_fragmentLink()
    {
        /**
         * tested in test_javaScriptLink2 test method
         */
    }

    public static function runTests()
    {
        self::test_javaScriptLink1();
        self::test_javaScriptLink2();
        self::test_fragmentLink();
        return ;
    }
}

/**
 * 
 * bugs:
 * we need to check the validity before getting 
 * the absHref and after it.
 */
ini_set('log_errors', 0);
urlFilterTester::runTests();
?>