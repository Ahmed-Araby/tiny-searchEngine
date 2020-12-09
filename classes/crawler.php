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

class crawler
{

}

?>