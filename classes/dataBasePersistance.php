<?php 

require_once "HELPERS.php";
class dataBasePersistance
{
    private static $pdo     = null;
    private static $pdoUrl  = "mysql:host=localhost;dbname=search_engine";
    private static $user    = 'root'; // this user have all privalage over my data base 
    private static $pass    = ''; // no pass 

    public function __construct()
    {
        newLine();
        echo "dataBasePersistance Class instinated";
        newLine();
    }

    public static function connect()
    {
        if(self::$pdo == null){
            newLine();
            echo "trying to connect ";
            newLine();
            
            self::$pdo = new PDO(self::$pdoUrl, self::$user, self::$pass);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            newLine();
            echo "connection success ";
            newLine();
        }
        return ;
    }

    public static function insertImg($imgUrl, $parentPageId)
    {
        try{
            self::connect();

            $insertQuery = "insert into images (url, page_fk) values (? , ?)";
            $stmt = self::$pdo->prepare($insertQuery);
            $stmt->bindValue(1, $imgUrl);
            $stmt->bindValue(2, $parentPageId);
            $success = $stmt->execute();
            if(!$success)
                throw new Exception("failure in inserting image url");
        }

        catch (Exception $e)
        {
            //newLine();
            // echo $e; // this one will be trigered alot
            //newLine();
            return false;
        }
        return true;
    }
    
    public static function insertPage($url, $metaData)
    {
        /**
         * save url into the pages table 
         * return it's id back 
         * handle inserting a duplicate 
         * 
         * will return the id of the url 
         * in both cases (newly inserted, already exist);
         * id = 
         * -1 -- not exist 
         * >=0 exist
         */

        $urlId = self::getUrlId($url);
        if($urlId >=0)
            return $urlId;
        
        // get meta data
        $description = $metaData['description'];
        $keywords = $metaData['keywords'];
        $title = $metaData['title'];

        // insert into the dataBase         
        try{
            self::connect();

            $insertQuery = "insert into pages (url, title, description, key_words) values (?, ?, ?, ?)";
            $stmt = self::$pdo->prepare($insertQuery);
            $stmt->bindValue(1, $url);
            $stmt->bindValue(2, $title);
            $stmt->bindValue(3, $description);
            $stmt->bindValue(4, $keywords);
            $success = $stmt->execute();
            if(!$success)
                throw new Exception("execute failed in insert page");
            $newPageId = self::$pdo->lastInsertId();
            return $newPageId;
        }

        catch(Exception $e){
            newLine();
            echo "** failure in inserting page";//$e;
            newLine();
            return 0; // google id. 
        }
    }

    public static function insertPointing($parentPageId, $childPageId)
    {
        /** parent url point at child url  
         * returns 
            * true if insertion success 
            * false if insertion failed.
        */
        try{
            self::connect();

            $query = "insert into pointing  values(?, ?)";
            $stmt = self::$pdo->prepare($query);
            $stmt->bindValue(1, $parentPageId);
            $stmt->bindValue(2, $childPageId);
            $success = $stmt->execute();
            if(!$success)
                throw new Exception("failure in inserting pointing record");
        }
        catch (Exception $e) {
            /** unique constraint may have been violated */
            newLine();
            echo "** failure in inserting pointing"; //$e;
            newLine();
            return false;
        }

        return true;
    }

    public static function getUrlId($url)
    {
        /*
        * should return the id 
        * if the id is negative then the url is not exist 
        * if the id is >=0 then the url exist with the returned id
        */

        try{
            self::connect();

            $selectQuery = "select id from pages where url = ?";
            $stmt = self::$pdo->prepare($selectQuery);
            $stmt->bindValue(1, $url);
            $stmt->execute();
            $row = $stmt->fetch();

            if($row === false)
                return -1;
            $id = $row['id'];
            return $id;
        }

        catch(Exception $e){
            /*
            * don't hult the crawler for this issue
            * we can afford skiping a url. 
            * afetr all I don't intend to compete with google.
            */

            newLine();
            echo "** failure in getUrlId";//$e;
            newLine();
            return 0; // google id. 
        }
    }

}

?>