<?php 

/**
 * description:
    * this class is responsible for applyign bfs search on the 
    * given and expored urls to explore the web, during this this 
    * class will make use of all classes we build
        * httpRequester to make request to the url in hand
        * htmlParser to get useful information from the html body of the page we requested
        * url filter to exclude bad hrefs that we don't want
        * urlResolver to convert href into absolute urls that are ready to be crawled [hopefully]
        * then usine dataBaseersistance we will save every url that make 200 ok response on crawling.

    * input:
        * seed of inital urls to start crawling.

    * output: 
        * Data base tables:
            * pages represented as [url, description, keywords, clicks]
            * reference represented at [pointerUrl, pointedAtUrl]
 */

require_once "HELPERS.php";
require_once "httpRequester.php";
require_once "urlResolver.php";
require_once "urlFilter.php";
require_once "htmlParser.php";
require_once "dataBasePersistance.php";

class crawler
{
    private static $urlQueue;
    public function __construct()
    {
        newLine();
        echo "crawler class instinated";
        newLine(); 
    }

    public static function seed($fileName)
    {
        newLine();
        echo "seeding from  " . $fileName ;
        newLine();

        $filePtr = fopen($fileName, "r");
        if($filePtr === false)
        {
            newLine();
            echo "failed to open " . $fileName . " file";
            return false;
            newLine();
        }

        while(!feof($filePtr)) // would this fail !!??
        {
            $url = fgets($filePtr);
            $url = trim($url);
            self::$urlQueue[] = $url;
        }

        return true;
    }

    public static function crawle($fileName, $maxDepth, $maxWidth, $urlsLimitCount)
    {
        self::$urlQueue = array();   
        if(self::seed($fileName) === false)
            throw new Exception("failed to seed the crawler");

        $currentDepth = 0;
        $currentWidth = 0;
        $exploredUrlsCount = 0;

        while(count(self::$urlQueue) != 0)
        {
            $url = array_shift(self::$urlQueue);

            // request
            $response = httpRequester::request($url);
            $statucCode = $response['status_code'];
            $contentType = $response['content_type'];

            if($response['status_code'] != 200 || 
                $response['content_type'] !== "text/html"){    
                    /*
                    newLine();
                    echo "[ Failure ] -- " . $url 
                         . " -- have status Code : " . $response['status_code']
                         . " and content type : " . $response['content_type'];
                    newLine();
                    */

                    continue;
                }

            $htmlBody = $response['body'];
            // end of request

            // [Debuging]
            echo "status code : " . $statucCode . " content type : " 
                . $contentType 
                ."url : " . $url;
            newLine();
            // end of debuging

            // parsing
            $htmlInfo = htmlPasrer::parse($htmlBody);
            // get meta Data 
            $metaData = $htmlInfo['metaData'];
            // end of parsing 

            //  persist current url
            /* */

            // insert hrefs into urlQueue
            $hrefs = $htmlInfo['anchorHrefs'];
            foreach($hrefs as $href)
            {
                // filter
                if(urlFilter::filter($href) === false){
                    /*
                    newLine();
                    echo "href : " . $href . "is rejected ";
                    newLine();
                    */
                    continue;
                }

                // resolve 
                $absHref = urlResolver::resolve($url, $href);

                self::$urlQueue[] = $absHref;
            }

            // persist images links into the data base
            $imgSrcs = $htmlInfo['imgSrcs'];
            foreach($imgSrcs as $imgSrc)
            {
                // filter 
                if(urlFilter::filter($imgSrc) === false){
                    /*
                    newLine();
                    echo "imgSrc : " . $imgSrc . "is rejected ";
                    newLine();
                    */
                    continue;
                }

                // resolve 
                $absImgSrc = urlResolver::resolve($url, $imgSrc);

                /** persisit to the data base  */
            }

            $exploredUrlsCount +=1;
            if($exploredUrlsCount == $urlsLimitCount)
                break;
        }
    }

}

$fileName = "files/seed.txt";
crawler::crawle($fileName, 1, 1, 100);

?>