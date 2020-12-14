<?php

require_once "HELPERS.php";

class checkExistence_inDataBase 
{
    private static $pdo     = null;
    private static $pdoUrl  = "mysql:host=localhost;dbname=search_engine";
    private static $user    = 'root'; // this user have all privalage over my data base 
    private static $pass    = ''; // no pass 

    public function __construct()
    {
        newLine();
        echo "CheckExistance_inDataBase class instance is instinated";
        newLine();
    }


    public static function connect()
    {
        if(self::$pdo == null){
            newLine();
            echo "trying to connect ";
            newLine();
            
            self::$pdo = new PDO(self::$pdoUrl, self::$user, self::$pass);
            /*
            we also could specify the error model to be warnnign 
            which will help the app not to hult on data base errors.
            */
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            newLine();
            echo "connection success ";
            newLine();
        }
        return ;
    }


    public static function is_page_url_exist($absUrl)
    {
        try{
            self::connect();
            $query = "select 1 from pages where url = ?";
            $stmt = self::$pdo->prepare($query);
            $stmt->bindValue(1, $absUrl);
            $success = $stmt->execute();
            
            if(!$success)    
                throw new Exception("is_page_url_exist failed in execution method ");

            if($stmt->fetch() == false)
                return false;            
        }
        catch (Exception $e)
        {
            newLine();
            echo $e->message;
            newLine();
        }

        return true;
    }

    public static function is_img_url_exist($absUrl)
    {
        try{
            self::connect();
            $query = "select 1 from images where url = ?";
            $stmt = self::$pdo->prepare($query);
            $stmt->bindValue(1, $absUrl);
            $success = $stmt->execute();
            
            if(!$success)    
                throw new Exception("is_page_url_exist failed in execution method ");

            if($stmt->fetch() == false)
                return false;            
        }
        catch (Exception $e)
        {
            newLine();
            echo $e->message;
            newLine();
        }

        return true;
    }

}
?>