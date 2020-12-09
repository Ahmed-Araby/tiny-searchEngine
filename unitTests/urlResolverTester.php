<?php 
    include('classes/urlResolver.php');

    function newLine()
    {
        echo "\n";
    }

    class urlResolverTester
    {
        public function __construct()
        {
            newLine();
            echo "testing url Resolver class";
            newLine();
        }

        private static function compare($urls, $hrefs, $results)
        {
            for($index =0; $index < count($urls); $index +=1)
            {
                $absUrl = urlResolver::resolve($urls[$index], $hrefs[$index]);
                if(trim($absUrl) !== trim($results[$index]))
                    throw new Exception(" \n no Match: $urls[$index],  $hrefs[$index],  $results[$index],  $absUrl");
            }
        }

        public static function test_absoluteHrefCase()
        {
            $urls = ["https://www.php.net/manual/en/",
                        "https://www.php.net/manual/en/install.general.php",
                        "https://www.php.net/manual/en/install.general.php"];

            $hrefs = ["https://www.google.com/index.html",
                        "https://www.google.com", 
                        "https://www.facebook.com/profile/pics/"];
            
            $results = ["https://www.google.com/index.html",
                        "https://www.google.com", 
                        "https://www.facebook.com/profile/pics/"];

            self::compare($urls, $hrefs, $results);
            
            return ;
        }

        public static function test_currentDirectoryRelativeHrefCase()
        {
            $urls = ["https://www.php.net/manual/en/",
                         "https://www.php.net/manual/en/install.general.php" ];
            
            $hrefs = ["install.general.php",
                         "intro-whatcando.php"];
            
            $results = ["https://www.php.net/manual/en/install.general.php",
                         "https://www.php.net/manual/en/intro-whatcando.php"];

            self::compare($urls, $hrefs, $results);

            return ;
        }

        public static function test_n_LevelUPDirectoryRelativeHrefCase()
        {
            $urls = ["https://www.php.net/manual/en/",
                         "https://www.php.net/manual/en/install.general.php", 
                         "https://www.php.net/manual/en/insts/install.general.php"];
            
            $hrefs = ["../install.general.php",
                         "../../intro-whatcando.php", 
                        "../../../index.php"];
            
            $results = ["https://www.php.net/manual/install.general.php",
                         "https://www.php.net/intro-whatcando.php", 
                         "https://www.php.net/index.php"];

            self::compare($urls, $hrefs, $results);

            return ;
        }
        
        public static function test_relativeToRootHrefCase()
        {
            $urls = ["https://www.php.net/manual/en/",
                    "https://www.php.net/manual/en/install.general.php" ,
                     "https://www.php.net/",
                      "http://www.google.com/manual/en/install.general.php",
                       "http://www.google.com/manual/en/install.general.php"];
            
            $hrefs = ["/install.general.php",
                         "/intro-whatcando.php", 
                          "/fields/index.php",
                           "/Ar/", 
                            "/ar"];
            
            $results = ["https://www.php.net/install.general.php",
                         "https://www.php.net/intro-whatcando.php" ,
                          "https://www.php.net/fields/index.php",
                           "http://www.google.com/Ar/",
                            "http://www.google.com/ar"];

         
            self::compare($urls, $hrefs, $results);
            return ;
        }

        public static function test_schemeRelativeHrefCase()
        {
            $urls = ["https://www.php.net/manual/en/",
                     "https://www.php.net/manual/en/install.general.php" ,
                      "https://www.php.net/",
                       "http://www.php.net/manual/en/install.general.php"];
            
            $hrefs = ["//www.php.net/manual/en/",
                     "//www.php.net/manual/en/install.general.php" ,
                      "//www.php.net/manual/en/install.general.php",
                       "//www.google.com/index.html"];
            
            $results = ["https://www.php.net/manual/en/",
                        "https://www.php.net/manual/en/install.general.php" , 
                        "https://www.php.net/manual/en/install.general.php",
                         "http://www.google.com/index.html"];

            self::compare($urls, $hrefs, $results);

            return ;
        }

        public static function randomTests()
        {
            /* to be implemented */
        }

        public static function runTests()
        {

            self::test_currentDirectoryRelativeHrefCase();
            newLine();
            echo " [ Success ] test_currentDirectoryRelativeHrefCase Test cases Passed ";
            newLine();            

            self::test_schemeRelativeHrefCase();
            newLine();
            echo " [ Success ] test_schemeRelativeHrefCase Test cases Passed ";
            newLine();
            
            self::test_relativeToRootHrefCase();
            newLine();
            echo " [ Success ] test_relativeToRootHrefCase Test cases Passed ";
            newLine();

            self:: test_n_LevelUPDirectoryRelativeHrefCase();
            newLine();
            echo " [ Success ] test_n_LevelUPDirectoryRelativeHrefCase Test cases Passed ";
            newLine();

            self:: test_absoluteHrefCase();
            newLine();
            echo " [ Success ] test_absoluteHrefCase Test cases Passed ";
            newLine();

            newLine();
            echo " [ Success ] All Test cases Passed ";
            newLine();
        }
        
    }

    ini_set("log_errors", 0);
    urlResolverTester::runTests();
?>
