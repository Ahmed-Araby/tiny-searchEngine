<?php 

require_once "HELPERS.php";
require_once "pdoFactory.php";

class pagesModel
{
    public function __construct()
    {
        
    }

    public function  getPagesResults($searchTerm, $startOffset, $limit)
    {
        /**
         * support paginatioon
         */
        try{
            $pdo = pdoFactory::getPdoInstance();
            if($pdo == null)
                throw new Exception("exception in getImagesResults : not able to connect to the data base");

            $query = "select url, title, description
                      from pages 
                      where lower (title) like ? or
                            lower (description) like ? or
                            lower (key_words) like ?
                        limit ?, ?";

            $stmt = $pdo->prepare($query);
            $searchTerm = "%". strtolower($searchTerm) . "%";
            $stmt->bindValue(1, $searchTerm);
            $stmt->bindValue(2, $searchTerm);
            $stmt->bindValue(3, $searchTerm);
            // pagination 
            $stmt->bindValue(4, $startOffset, PDO::PARAM_INT);
            $stmt->bindValue(5, $limit, PDO::PARAM_INT);

            $success = $stmt->execute();
            if(!$success)
                throw new Exception("exception from getSearchResults : failure in execution ");
            
            $results = [];
            while($row = $stmt->fetch())
                $results [] = $row;

            return $results;
        }

        catch(Exception $e)
        {
            newLine();
            echo $e->getMessage();
            newLine();
        }

        return array(); // empty results
    }

    public function getTotNumOfPagesResults($searchTerm)
    {
        try{
            $pdo = pdoFactory::getPdoInstance();
            if($pdo == null)
                throw new Exception("exception in getImagesResults : not able to connect to the data base");

            $query = "select count(*) 
                        from pages 
                        where lower (title) like ? or
                             lower (description) like ? or
                              lower (key_words) like ?";
                              
            $stmt = $pdo->prepare($query);
            $searchTerm = "%". strtolower($searchTerm) . "%";
            $stmt->bindValue(1, $searchTerm);
            $stmt->bindValue(2, $searchTerm);
            $stmt->bindValue(3, $searchTerm);

            $success = $stmt->execute();
            if(!$success)
                throw new Exception("exception in getTotalNumberOfResults, failure in execute");

            $count = $stmt->fetch()[0];
            return $count;
        }

        catch (Exception  $e)
        {
            newLine();
            echo $e->getMessage();
            newLine();
        }

        return -1; // indicate failure
    }

}