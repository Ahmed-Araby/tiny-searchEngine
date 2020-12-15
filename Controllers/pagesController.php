<?php 

require_once "Models/pagesModel.php";

class pagesController
{
    private $resultsPerPage = 10; 

    public function __construct()
    {
    }

    public function getTotalNumOfPagesResults($searchTerm)
    {
        $pagesModelObj = new pagesModel();
        $totalNumOfResults = $pagesModelObj->getTotNumOfPagesResults($searchTerm);
        
        return $totalNumOfResults;
    }

    public function getPagesResults($searchTerm, $pageNumber)
    {
        $startOffSet = ($pageNumber - 1) *  $this->resultsPerPage;
        $pagesModelObj = new pagesModel();
        $searchResults = $pagesModelObj->getPagesResults($searchTerm, $startOffSet, $this->resultsPerPage);
        
        return $searchResults;
    }

}