<?php 
/**
 * description:
    * responsibility of this class is to take the html body 
    * and return the needed information for the crawler like 
    * anchor links tags
    * image tags 
    * meta data -- for data base indexing.
        * title of the page 
        * description of the page
        * key words
 * 
 * input: 
    * html body of the page we requested
 * output:
    * needed data menitioned above.
*/

require_once "HELPERS.php";
require_once "urlResolver.php";

class htmlPasrer
{
    private static $domObject = null;

    public function __construct()
    {
        newLine();
        echo " html Parser initiated ";
        newLine();
    }

    private static function getAnchorHrefs($domObject)
    {
        // return list of anchor hrefs.
        $anchors = $domObject->getElementsByTagName('a');
        $hrefs = array();
        foreach($anchors as $anchor)
        {
            $href = $anchor->getAttribute('href');
            $hrefs[] = $href;
        }
        return $hrefs;
    }

    private static function getImagesData($domObject)
    {
        /** 
         * urls in the src attribute could be relative
        */

        $imgs = $domObject->getElementsByTagName('img');
        $imgsData = array();
        foreach($imgs as $img)
        {
            $src = $img->getAttribute('src');
            $alt = $img->getAttribute('alt');
            $title = $img->getAttribute('title');

            $imgsData [] = array("src"   => $src, 
                                 "alt"   => $alt, 
                                 "title" => $title);
        }

        return $imgsData;
    }

    private static function getMetaData($domObject)
    {
        // return array of meta data for the search engine indexing

        $metaNodes = $domObject->getElementsByTagName('meta');
        $titles    = $domObject->getElementsByTagName('title');

        $metaData = array("description" => "", 
                            "keywords"  => "", 
                            "title"     => "");

        foreach($titles as $title){
            $titleValue = $title->nodeValue;
            $metaData['title'] = $metaData['title'] 
                                    . ($metaData['title']==""?"":" ")
                                    . strtolower($titleValue);
        }
        
        foreach($metaNodes as $node)
        {
            $nodeName    = strtolower($node->getAttribute('name'));
            $nodeContent = strtolower($node->getAttribute('content'));

            if($nodeName == "description" || 
                $nodeName == "keywords" )

                $metaData[$nodeName] = $metaData[$nodeName] 
                                        . ($metaData[$nodeName]==""?"":" ")
                                        . $nodeContent;
            
        }

        return $metaData;
    }

    public static function parse($htmlBody)
    { 
        $domObject = new DOMDocument();
        @ $domObject->loadHtml($htmlBody); 

        $absAnchorUrls = self::getAnchorHrefs($domObject);
        $imgsData = self::getImagesData($domObject); // array of arrays 
        $metaData = self::getMetaData($domObject);

        return array(
            "anchorHrefs" => $absAnchorUrls,
            "imgsData"  => $imgsData, 
            "metaData"      =>$metaData 
        );
    }

}

?>