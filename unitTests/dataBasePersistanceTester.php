<?php 

require_once "HELPERS.php";
require_once "classes/dataBasePersistance.php";

class dataBasePersistanceTester
{
    public function __construct()
    {
        newLine();
        echo "dataBasePersistanceTester instinated";
        newLine();
    }

    private static function test_getUrlId_notExistUrl()
    {
        $url = "not exist url";
        $id = dataBasePersistance::getUrlId($url);
        if($id != -1)
            throw new Exception("this url should not be in the data base");
        return true;
    }

    private static function test_getUrlId_existUrl()
    {
        $url = "https://www.google.com/";
        $id = dataBasePersistance::getUrlId($url);
        if($id != 0)
            throw new Exception("this is google url it have to have id = 0");
        return true;
    }

    private static function test_urlExist($url)
    {
        $id = dataBasePersistance::getUrlId($url);
        return ($id >=0);
    }

    private static function test_insertPage_pageNotExist()
    {
        $url ='https://www.ahmedAraby22.com/';
        $metaData = array("description" => "", 
                            "keywords"  => "", 
                                "title"     => "");
        $newId = dataBasePersistance::insertPage($url, $metaData);
        newLine();
        echo $url . " inserter with id " . $newId;
        newLine();
        
        /**we could test this by checking that the id 
         * is bugger than the biggest id exist in the data base 
         * before this insertion 
         */
        return true;
    }

    private static function test_insertPage_pageExist()
    {
        $url ='https://www.ahmedAraby.com/';
        $metaData = array("description" => "", 
                            "keywords"  => "", 
                                "title"     => "");

        $exist = self::test_urlExist($url);
        $newId = dataBasePersistance::insertPage($url, $metaData);
        
        newLine();
        echo "from insert page exist \n " . $url . " inserted with id " . $newId . 
        " \n exist test  " . ($exist===True?"true":"false");
        newLine();
        
        return true;
    }

    private static function test_insertPointing_notExist()
    {
        $parentPageId = 2;
        $childPageId = 4;
        $success = dataBasePersistance::insertPointing($parentPageId, $childPageId);
        if($success == true)
            return true;
        else{
            throw new Exception("failure record supposed to be new and should be inserted");
        }
    }

    private static function test_insertPointing_Exist()
    {
        $parentPageId = 0;
        $childPageId = 4;
        $success = dataBasePersistance::insertPointing($parentPageId, $childPageId);
        if($success == false)
            return true;
        else{
            throw new Exception("failure record already exist we sholud not be able to insert a new record");
        }
    }

    private static function test_insertPointing_pages_not_exist()
    {
        $parentPageId = 0;
        $childPageId = 20;
        $success = dataBasePersistance::insertPointing($parentPageId, $childPageId);
        if($success == false)
            return true;
        else{
            throw new Exception("failure record supposed to be new and should be inserted");
        }
    }

    public static function runTests()
    {
        self::test_getUrlId_notExistUrl();
        self::test_getUrlId_existUrl();
        self::test_insertPage_pageNotExist();
        self::test_insertPage_pageExist();

        // we need to provide new values inside the test
        self::test_insertPointing_notExist(); 
        
        //self::test_insertPointing_pages_not_exist();
        //self::test_insertPointing_Exist();

        newLine();
        echo "[ success in testing  dataBasePersistance class]";
        newLine();
    }

}

dataBasePersistanceTester::runTests();

?>