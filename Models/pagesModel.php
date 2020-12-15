<?php 

require_once "HELPERS.php";

class pagesModel
{
    private static $pdo     = null;
    private static $pdoUrl  = "mysql:host=localhost;dbname=search_engine";
    private static $user    = 'root'; // this user have all privalage over my data base 
    private static $pass    = ''; // no pass 


    public function __construct()
    {
        
    }

    public static function connect()
    {
        if(self::$pdo == null){
            self::$pdo = new PDO(self::$pdoUrl, self::$user, self::$pass);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return ;
    }


    public static function  getSearchResults($searchTerm, $startOffset, $limit)
    {
        /**
         * support paginatioon
         */
        try{
            self::connect();
            $query = "select url, title, description
                      from pages 
                      where lower (title) like ? or
                            lower (description) like ? or
                            lower (key_words) like ?
                        limit ?, ?";

            $stmt = self::$pdo->prepare($query);
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

    public static function getTotalNumberOfResults($searchTerm)
    {
        try{
            self::connect();
            $query = "select count(*) 
                        from pages 
                        where lower (title) like ? or
                             lower (description) like ? or
                              lower (key_words) like ?";
                              
            $stmt = self::$pdo->prepare($query);
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