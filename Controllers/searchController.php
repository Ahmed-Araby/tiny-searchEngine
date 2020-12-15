<?php 

require_once "Models/pagesModel.php";

class searchController
{
    private static $resultsPerPage = 10;

    public function __construct()
    {

    }

    public static function getTotalNumOfResults($searchTerm)
    {
        $totalNumOfResults = pagesModel::getTotalNumberOfResults($searchTerm);
        return $totalNumOfResults;
    }
    public static function getSearchResults($searchTerm, $searchType, $pageNumber)
    {
        $startOffSet = ($pageNumber - 1) * self::$resultsPerPage;
        $searchResults = pagesModel::getSearchResults($searchTerm, $startOffSet, self::$resultsPerPage);
        
        return $searchResults;
    }

}