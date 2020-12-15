<?php 

/**
 * this class is responsible for providing 
 * only 1 instance of the pdo throw the entire application
 * using singlton pattern
 * 
 */

 class pdoFactory
 {
     
    private static $pdo     = null;
    private static $pdoUrl  = "mysql:host=localhost;dbname=search_engine";
    private static $user    = 'root'; // this user have all privalage over my data base 
    private static $pass    = ''; // no pass 

    public function __construct()
    {   
        echo "\n pdoFactory Class has been instinated \n";
    }

    public static function connect()
    {
        if(self::$pdo == null){
            self::$pdo = new PDO(self::$pdoUrl, self::$user, self::$pass,
             array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return ;
    }


    public static function getPdoInstance()
    {
        self::connect();
        return self::$pdo;
    }
     
 }
