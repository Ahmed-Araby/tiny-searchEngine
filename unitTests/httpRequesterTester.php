<?php

    include_once("classes/httpRequester.php");
    class httpRequesterTester
    {
        public function __construct()
        {
            newLine();
            echo "http requester tester initiated";
            newLine();
        }

        private static function test_200_okStatue()
        {
            $url = "https://www.php.net/manual/en/";
            $response = httpRequester::request($url);
            var_dump($response);
        }

        private static function test_301_then_200_okStatue()
        {
            $url = "https://www.php.net/manual/en";
            $response = httpRequester::request($url);
            var_dump($response);
        }

        public static function runTests()
        {   
            self::test_200_okStatue();
            newLine();
            newLine();

            self::test_301_then_200_okStatue();
            newLine();
            newLine();

            echo "computional checking wont be very usefull ";
            newLine();
            return ;
        }
    }
    httpRequesterTester::runTests();
?>