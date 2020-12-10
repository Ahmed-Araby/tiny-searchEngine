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

 class urlFilter
 {
     public function __construct()
     {
         newLine();
         echo "urlFilter class instinated ";
         newLine();
     }
     public static function filter($href)
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
        
        /*
         * duplicated link 
         * will be handled on the data abse insertion 
         * using the unique propeerty.
        */

        return true;
     }
 }
?>