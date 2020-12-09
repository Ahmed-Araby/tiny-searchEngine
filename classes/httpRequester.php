<?php 
/**
 * description:
 * 
 * the responsibility of this class is to take care of every thing related to the Http requests 
 * send get requets
 * react to redirect 301 response
 * analysing the headers from the http response 
 * add custom headers to my request if neded
 * 
 * input: 
 * absolute url
 * 
 * output:
 * associative array that includeds:
    * code_status to the crawler to act based on it.
    * type of the document.
    * html document.
 * 
 * 
 */
 
 require_once "urlResolver.php";
 require_once "HELPERS.php";
 
 class httpRequester
 {
     private static $redirected = false;

     public function __construct()
     {
         newLine();
         echo "httpRequester class instinated";
         newLine();
     }

     public static function request($url)
     {

        $curl = curl_init();         
        curl_setopt_array($curl,
            array(
                 CURLOPT_URL => $url, 
                 CURLOPT_HEADER => false,  // dont return the headers in the response. 
                 CURLOPT_RETURNTRANSFER => true   // prevent the extension from printing the response. 
                )
            );
        
        $body = curl_exec($curl);
        $statusCode  = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

        $contentType = explode(';', $contentType)[0];
        $contentType = strtolower($contentType);

        $response = array("status_code" => $statusCode, 
                            "content_type" => $contentType, 
                            "redirection" => false,
                            "redirection_url" => "",
                            "body" => $body);
        
        /**get redirection codes !!??
         * wiered different kinds of redirectin
         * including (permeneant and temporary).
         * 
         * take care as redirection url could be absolute or relative
         */        
        
        if ($statusCode >=300  && 
            $statusCode< 400 && 
            self::$redirected == false){

            self::$redirected = true; //no more than 1 redirection., feels like lock.
            
            $redirectionUrl = curl_getinfo($curl, CURLINFO_REDIRECT_URL);
            $absoluteRedirectionUrl = urlResolver::resolve($url, $redirectionUrl);
            $response = self::request($absoluteRedirectionUrl);
            
            $response['redirection'] = true;
            $response['redirection_url'] = $absoluteRedirectionUrl;
            
            self::$redirected = false;
        }

        curl_close($curl);

        return $response;
     }
 }

?>