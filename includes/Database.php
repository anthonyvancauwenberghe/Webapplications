<?php
ini_set('mongo.long_as_object', 1);

class Database
{

    /* DB connection */
    protected static $connection;

    /* Config File */
    protected static $config = null;
    
    public function connect()
    {

        $this->getConfig();
        if (!isset(self::$connection)) {
            self::$connection = new MongoClient('mongodb://' . self::$config['host'] . ':' . self::$config['port'] . '/' . self::$config['authdb'], array('username' => self::$config['username'], 'password' => self::$config['password'], 'replicaSet' => false, 'connect' => false));
        }

        //TODO ERROR HANDLING

        return self::$connection;
    }

    public function getConfig()
    {

        if (self::$config == null) {
            self::$config = parse_ini_file('config.ini');
        }

        return self::$config;
    }

    
}


?>