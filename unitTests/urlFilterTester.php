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
        $valid = urlFilter::filter($url, $url);
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
            $valid = urlFilter::filter($url, $href);

            newLine();
            echo "href: $href \n"
            . ($valid === true?"valid ": "in valid");
            newLine();
        }

        return ;
    }

    public static function test_is_200()
    {
        // working url 
        $url1 = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTKDZXX4RiN6HaNwY20GO4q_5pokzIwiJC-_A&usqp=CAU";
        $_200ok1 = urlFilter::filter($url1, $url1);
        if($_200ok1 !=true)
            throw new Exception("in test_is_200 -- url1 should return 200 ok");
        // not wokring url 
        $url2 = "https://ichef.bbc.co.uk/wwhp/144/cpsprodpb/66C4/production/_115980362_hi064727083";
        $_200ok2 = urlFilter::filter($url2, $url2);
        if($_200ok2 !=false)
            throw new Exception("in test_is_200 -- url2 should fail in loading ");

        // we need to test redirection

        newLine();
        echo "success in test_is_200";
        newLine();
        return true;
    }

    public static function test_urlExistinDataBase()
    {
        $imgUrl1 = "https://ichef.bbc.co.uk/wwhp/144/cpsprodpb/14E68/production/_115980658_tv064724422.jpg";
        $pageUrl1 = "https://www.google.com/";
        
        $valid1 = urlFilter::filter($imgUrl1, $imgUrl1);
        if($valid1 == true)
            throw new Exception("test_urlExistinDataBase image exist in the data base");

        $valid2 = urlFilter::filter($pageUrl1, $pageUrl1);
        if($valid2 == true)
            throw new Exception("test_urlExistinDataBase page exist in the data base");

        return true;
    }

    public static function test_urlNotExistinDataBase()
    {
        
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
        self::test_is_200();
        self::test_urlExistinDataBase();
              
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