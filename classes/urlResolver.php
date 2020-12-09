<?php
/*

author: Ahmed Araby Kamel
Description:

responsibility of this class is 
to resolve all href of the anchor links in the pages
that we crawle to be an absolute url.


input:

href of some anchor from the current site HTML document and base url of the current site.

output: 

return absolute url that lead to the same destionation 
as if we clicked on the anchor of the href we have.

Cases:

https://www.websiteA.com/index.html  -- absolute url 

//www.websiteA.com/index.html -- scheme relative to the cuurent site 

/index.html  -- link relative to the root directory [HOST]

[1 case ]
../index.html -- go up in the direcory 1 level then be relative 
../../index.html -- go up 2 level, intend here to handle dynamic version of this behaviour.
../*(n)index.html -- go up n level   [General Case]

[1 case]
./index.html -- link relative to the current directory
index.html  -- link relative to the current directory

*/

class urlResolver
{
    public function __construct()
    {
        echo "\n URIResolver class instinated \n";
    }

    public static function resolve($baseUrl, $href)
    {
        $baseUrlParts = parse_url($baseUrl);
        $baseUrlScheme = $baseUrlParts['scheme'];
        $baseUrlHost = $baseUrlParts['host'];

        /* remember php have no if scope for variables */
        if (key_exists("path", $baseUrlParts))
            $baseUrlPath = $baseUrlParts['path'];
        else
            $baseUrlPath = "";

        /*
         * path could be directory this is due to the fact that some 
         * web servers have default resource that they look for inside each directory.
         * 
         * if the path ends with / then it's the current directory 
         * directory will have / at the begining and at the end.
        */

        if($baseUrlPath == "")
            $baseUrlDirectory = "";

        else if(substr($baseUrlPath, -1, 1) === "/")
            $baseUrlDirectory = $baseUrlPath;
        
        else
            $baseUrlDirectory = dirname($baseUrlPath, 1) . "/";

        // absolute url (http, https)
        if(substr($href, 0, 4) === "http")
            return $href;
        
        // relative to the cuurent scheme (http, https)
        if(substr($href, 0, 2) === "//")
            return $baseUrlScheme . ":" .$href;

        // relative to the root directory [HOST];
        if(substr($href, 0, 1) === '/') {
            // clean the href 
            $href = ltrim($href, '/');
            return self::buildAbsoluteUrl($baseUrlScheme, $baseUrlHost, $href);
        }

        // go up in the directory structure
        if(substr($href, 0, 3) === "../")
        {
            while(substr($href, 0, 3) === "../")
            {
                // go up one level in the directory
                $baseUrlDirectory = dirname($baseUrlDirectory, 1);
             
                //clean href 
                $href = substr_replace($href, "", 0, 3);
                if($baseUrlDirectory == '\\')
                    break;
            }

            if( $baseUrlDirectory == '.' ||
                $baseUrlDirectory == "\\" ||
                $baseUrlDirectory == '/')

                $baseUrlDirectory = "";

            else if(substr($baseUrlDirectory, -1, 1) !='/')  //  this will be always true.
                $baseUrlDirectory = $baseUrlDirectory . "/";

            return self::buildAbsoluteUrl($baseUrlScheme, $baseUrlHost, $href, $baseUrlDirectory);
        }

        // relative to the current directory
        else
        {
            // clean the href
            if(substr($href, 0, 2) == "./") 
                $href = ltrim($href, './');
            return self::buildAbsoluteUrl($baseUrlScheme, $baseUrlHost, $href, $baseUrlDirectory);
        }
    }

    private static function buildAbsoluteUrl($scheme, $host , $href , $directory="")
    {
        /**
         
        * input:
            * host have no directory seprator before or after.
            * directory always will have directory seprator before and after.
            * href have no directory seprator or relativety indicator before it.
         * returns 
            * absolute URL.
            
         */

        $url = $scheme . "://" . $host;
        if($directory !="")
            return $url = $url . $directory . $href;
        else 
            return $url = $url ."/" . $href;
    }
}

?>