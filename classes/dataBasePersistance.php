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
    
    public static function insertPage($url, $metaData)
    {
        /**
         * save url into the pages table 
         * return it's id back 
         * handle inserting a duplicate 
         * 
         * will return the id of the url in both cases (newly inserted, already exist);
         */

        self::connect();
        $urlId = self::getUrlId($url);
        if($urlId >=0)
            return $urlId;
        
        // get meta data
        $description = $metaData['description'];
        $keywords = $metaData['keywords'];
        $title = $metaData['title'];

        // insert into the dataBase         
        try{
            $insertQuery = "insert into pages (url, title, description, keywords) values (?, ?, ?, ?)";
            $stmt = self::$pdo->prepare($insertQuery);
            $stmt->bindValue(1, $url);
            $stmt->bindValue(2, $title);
            $stmt->bindValue(3, $description);
            $stmt->bindValue(4, $keywords);
            $success = $stmt->execute();
            if(!$success)
                throw new Exception("execute failed in insert page");
            $newPageId = self::$pdo->lastInsertedId();
            return $newPageId;
        }

        catch(Exception $e){
            newLine();
            echo "exception at insertPage " . $e;
            newLine();
            return 0; // google id. 
        }
    }

    public static function insertPointing()
    {
        throw new Exception("not implemented yet");
    }

    public static function getUrlId($url)
    {
        /*
        * should return the id 
        * if the id is negative then the url is not exist 
        * if the id is >=0 then the url exist with the returned id
        */

        self::connect();
        try{
            $selectQuery = "select id from pages where url = ?";
            $stmt = self::$pdo->prepare($selectQuery);
            $stmt->bindValue(1, $url);
            
            $stmt->execute();
            $row = $stmt->fetch();
            if($row === false){
                echo "not exist";
                return -1;
            }

            $id = $row['id'];
            echo "exist with id : " . $id;
        }
        catch(Exception $e){
            /*
            * don't hult the crawler for this issue
            * we can afford skiping a url. 
            * afetr all I don't intend to compete with google.
            */

            newLine();
            echo "exception at urlExist " . $e;
            newLine();
            return 0; // google id. 
        }
    }

}
dataBasePersistance::getUrlId("hey1");
?>