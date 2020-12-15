<?php 

require_once "HELPERS.php";
require_once "pdoFactory.php";

class imagesModel
{   
    public function __construct()
    {
        
    }

    public function getTotNumOfImgsResults($searchTerm)
    {
        try{
            $pdo = pdoFactory::getPdoInstance();
            if($pdo == null)
                throw new Exception("exception in getImagesResults : not able to connect to the data base");
    
            $searchTerm = "%" . $searchTerm . "%";
            $query = 'select count(*)
                        from images 
                        where alt like ? or 
                            title like ?';

            $stmt = $pdo->prepare($query);
            $stmt->bindValue(1, $searchTerm);
            $stmt->bindValue(2, $searchTerm);

            $success = $stmt->execute();
            if(!$success)
                throw new Exception("exception in getPdoInstance : execution failed");

            return $stmt->fetch()[0];
        }
        
        catch(Exception $e)
        {
            newLine();
            echo $e->getMessage();
            newLine();
        }

        return -1; // indicate failure
    }

    public function getImagesResults($searchTerm, $startOffset, $limit)
    {
        try{
            $pdo = pdoFactory::getPdoInstance();

            if($pdo == null)
                throw new Exception("exception in getImagesResults : not able to connect to the data base");
            
            $searchTerm = "%" . $searchTerm . "%";

            $query = 'select images.url as imageUrl, pages.url as pageUrl, alt, images.title
                        from images 
                        left join pages 
                        on images.page_fk = pages.id
                        where alt like ? or 
                            images.title like ?
                            limit ?, ?';
            $stmt = $pdo->prepare($query);

            $stmt->bindValue(1, $searchTerm);
            $stmt->bindValue(2, $searchTerm);
            $stmt->bindValue(3, $startOffset, PDO::PARAM_INT);
            $stmt->bindValue(4, $limit, PDO::PARAM_INT);

            $success = $stmt->execute();
            if(!$success)
                throw new Exception("exception in getPdoInstance : execution failed");
            
            
            // return data 
            $imagesResults = array();
            while($row = $stmt->fetch())
                $imagesResults [] = $row;
            
            return $imagesResults;
        }
        
        catch(Exception $e)
        {
            newLine();
            echo $e->getMessage();
            newLine();
        }

        return array();
    }
}
?>