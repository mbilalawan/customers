<?php
class dbConnectionPDO
{
    private static $dbName = 'customers_db' ;
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'root';
    private static $dbUserPassword = 'test';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";charset=utf8;dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
		  self::$cont->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // tells PDO to disable emulated prepared statements and use real prepared statements

        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>
