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
    private static $parentIdQueue;
    private static $googleId = 0; // from my data base -- hard coded

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
            self::$parentIdQueue[] = self::$googleId;
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
            $url = array_shift(self::$urlQueue); // absolute url
            $parentId = array_shift(self::$parentIdQueue);
            
            // request
            $response = httpRequester::request($url);
            $statucCode = $response['status_code'];
            $contentType = $response['content_type'];
            // request failure 
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

            // [Debuging]
            echo "status code : " . $statucCode . " content type : " 
                . $contentType 
                ."url : " . $url;
            newLine();
            // end of debuging

            // parsing
            $htmlInfo = htmlPasrer::parse($htmlBody);
            $metaData = $htmlInfo['metaData'];

            //  persist current url
            $currentPageId = dataBasePersistance::insertPage($url, $metaData);
            // persist pointing relation 
            dataBasePersistance::insertPointing($parentId, $currentPageId);

            // insert hrefs into urlQueue
            $hrefs = $htmlInfo['anchorHrefs'];
            echo count($hrefs) . "  href parsed";
            newLine();
            newLine();
            
            foreach($hrefs as $href)
            {
                // filter
                if(urlFilter::filter($url, $href) === false){
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
                self::$parentIdQueue[] = $currentPageId; // parent page 
            }

            // persist images links into the data base
            $imgsData = $htmlInfo['imgsData'];
            foreach($imgsData as $imgData)
            {
                // filter 
                $imgSrc = $imgData['src'];
                $imgAlt = $imgData['alt'];
                $imgTitle = $imgData['title'];

                if(urlFilter::filter($url, $imgSrc) === false){
                    /*
                    newLine();
                    echo "imgSrc : " . $imgSrc . "is rejected ";
                    newLine();
                    */
                    continue;
                }

                // resolve 
                $absImgSrc = urlResolver::resolve($url, $imgSrc);
                dataBasePersistance::insertImg($absImgSrc, $imgAlt, $imgTitle, $currentPageId);
            }

            $exploredUrlsCount +=1;
            if($exploredUrlsCount == $urlsLimitCount)
                break;
        }
    }

}
?>