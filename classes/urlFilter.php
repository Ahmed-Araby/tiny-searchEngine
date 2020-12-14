<?php 

/**
 * description:
    * the responsibility of this class is to check 
    * if the given url is one of the urls that we want 
    * to ignore. 
 * 
 * input:
    * href
 * 
 * output:
    * false other wise.
    * true if to be ignored.
 */

 require_once "HELPERS.php";
 require_once "urlResolver.php";
 require_once "httpRequester.php";

 class urlFilter
 {
     public function __construct()
     {
         newLine();
         echo "urlFilter class instinated ";
         newLine();
     }

     public static function filter($baseUrl, $href)
     {
        /**
        * $href is not garanted to be absolute
        * true -- mean valid url to use 
        * false -- rejected url
        * this method is made to be extended very easily.
        */
    
        // link that will execute java script code
        $p1Length = strlen("javascript:");
        if(substr($href, 0, $p1Length) === "javascript:")
            return false;

        // link that point at some element in the same page.
        if(strpos($href, "#") !==false)
            return false;      
        
        // links that won't respond with 200 ok 
        $absHref = urlResolver::resolve($baseUrl, $href);
        $_200ok = httpRequester::is_200($absHref);
        if($_200ok == false)
            return false;
        
        // links that exist in the data base
        
        // link that exist in the urlQueur of the crawler

        /*
         * duplicated link 
         * will be handled on the data base insertion 
         * using the unique propeerty.
        */

        return true;
     }
 }
?>