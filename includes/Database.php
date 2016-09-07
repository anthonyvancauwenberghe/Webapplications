<?php
ini_set('mongo.long_as_object', 1);
require "/var/www/html/vendor/autoload.php";
class Database
{

    /* DB connection */
    private static $connection;

    /* Config File */
    private static $config;
    private static $DBInfoConfig;
    
    public static function connect()
    {
        if (!isset(self::$connection)) {
            self::getConfig();
            try {
                self::$connection = new MongoDB\Client('mongodb://' . self::$config['host'] . ':' . self::$config['port'] . '/' . self::$config['authdb'],
                    array('username' => self::$config['username'], 'password' => self::$config['password'], 'replicaSet' => false, 'connect' => false),
                    ['typeMap' => ['root' => 'array', 'document' => 'array', 'array' => 'array']]);
            } catch(MongoConnectionException $e) {
                trigger_error('Mongodb not available', E_USER_ERROR);
                die();
            }

        }

        //TODO ERROR HANDLING

        return self::$connection;
    }

    public static function getConfig()
    {

        if (self::$config == null) {
            self::$config = parse_ini_file('config.ini');
        }

        return self::$config;
    }

    public static function getDatabaseInfoConfig()
    {
        if (self::$DBInfoConfig == null) {
            self::$DBInfoConfig = parse_ini_file('DBInfo.ini');
        }

        return self::$DBInfoConfig;
    }

    
}


?>