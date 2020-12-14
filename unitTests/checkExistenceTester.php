<?php 

require_once "HELPERS.php";
require_once "classes/checkExistence_inDataBase.php";

class checkExistenceTester
{
    public function __construct()
    {      
    }


    private static function  test_pageUrlExist()
    {
        $url = "https://www.google.com/";
        $exist = checkExistence_inDataBase::is_page_url_exist($url);
        if($exist == false)
            throw new Exception("in test_pageUrlExist -- url have to exist exist ");
        true;
    }

    private static function  test_pageUrlNotExist()
    {
        $url = "https://www.facebook.com/ahmed.albarbary.90/";
        $exist = checkExistence_inDataBase::is_page_url_exist($url);
        if($exist == true)
            throw new Exception("in test_pageUrlNotExist -- url must be not exist ");
        return true;
    }

    private static function  test_imgUrlExist()
    {
        $url = "https://ichef.bbc.co.uk/wwhp/144/cpsprodpb/66C4/production/_115980362_hi064727083.jpg";
        $exist = checkExistence_inDataBase::is_img_url_exist($url);
        if($exist == false)
            throw new Exception("in test_imgUrlExist -- url have to exist exist ");
        true;
    }

    private static function  test_imgUrlNotExist()
    {
        $url = "https://ichef.bbc.co.uk/wwhp/144/cpsprodpb/66C4/production/_115980362_hi064727083";
        $exist = checkExistence_inDataBase::is_img_url_exist($url);
        if($exist == true)
            throw new Exception("in test_imgUrlExist -- url must be not exist ");
        return true;
    }

    public static function runTest()
    {
        self::test_pageUrlExist();
        self::test_pageUrlNotExist();
        self::test_imgUrlExist();
        self::test_imgUrlNotExist();

        newLine();
        echo "test success in checkExistanceTester class";
        newLine();
    }

}


checkExistenceTester::runTest();

?>