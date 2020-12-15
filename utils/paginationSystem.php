<?php 

class paginationSystem
{
    public function __construct()
    {   
    }

    public function getBoundries($totalNumberOfPages,$numberOfHrefs, $currentPageNumber)
    {
        
        /* 
        in case of even subtract 1 from number of hrefs 
        to be displayed after the current page href
        */

        $subtract = ($numberOfHrefs % 2 == 0? 1:0);
        
        // end calculation 
        $end  = max(  $currentPageNumber + $numberOfHrefs/2 - $subtract  , $numberOfHrefs);
        $end = min($end, $totalNumberOfPages);

        // start calculation 
        $start = max(1, $currentPageNumber - $numberOfHrefs / 2);
        if($end-$start+1 < $numberOfHrefs)
        {
            $remaining = $numberOfHrefs - ($end - $start + 1);
            $start = max(1, $start - $remaining);
        }

        return array("start"=>$start,
                    "end"=>$end);
    }
}