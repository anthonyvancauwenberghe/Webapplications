<?php
include 'Database.php';

/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 15/06/2016
 * Time: 21:21
 */
class Data
{
    /* Database */
    protected static $database;
    protected static $config;
    protected static $connection;

    /* DB collections */
    protected static $logsCollection;
    protected static $donationsCollection;
    protected static $votesCollection;
    protected static $charactersCollection;
    protected static $ipCollection;
    protected static $npcDropsCollection;
    protected static $npcDefinitionsCollection;
    protected static $worldNpcsCollection;
    protected static $itemDefinitionsCollection;
    protected static $shopsCollection;
    protected static $punishmentsCollection;


    /**
     * @return Database
     */
    private static function getDatabase()
    {
        if (!isset(self::$database)) {
            self::$database = new Database;
        }
        return self::$database;
    }

    private static function getConnection(){
        if (!isset(self::$connection)) {
           self::$connection =  self::getDatabase()->connect();
        }
        return self::$connection;
    }

    private static function getConfig()
    {

        if (!isset(self::$config)) {
            self::$config = self::getDatabase()->getConfig();
        }
        return self::$config;
    }

    /**
     * @return array|null
     */


    public function getDonationsCollection()
    {
        if (!isset(self::$donationsCollection)) {
            $config = $this->getConfig();
            $collection = $config['donationsCollection'];
            self::$donationsCollection = $this->getConnection()->selectDB(self::$config['mainDB'])->$collection;
        }

        return self::$donationsCollection;
    }

    public function getVotesCollection()
    {

        if (!isset(self::$votesCollection)) {
            $config = $this->getConfig();
            $collection = $config['votesCollection'];
            self::$votesCollection = $this->getConnection()->selectDB(self::$config['mainDB'])->$collection;
        }

        return self::$votesCollection;
    }

    public function geNpcDropsCollection()
    {

        if (!isset(self::$npcDropsCollection)) {
            $config = $this->getConfig();
            $collection = $config['npcDropsCollection'];
            self::$npcDropsCollection = $this->getConnection()->selectDB(self::$config['Definitions'])->$collection;
        }

        return self::$npcDropsCollection;
    }

    public function getNpcDefinitionsCollection()
    {

        if (!isset(self::$npcDefinitionsCollection)) {
            $config = $this->getConfig();
            $collection = $config['npcDefinitionsCollection'];
            self::$npcDefinitionsCollection = $this->getConnection()->selectDB(self::$config['Definitions'])->$collection;
        }

        return self::$npcDefinitionsCollection;
    }

    public function getWorldNpcsCollection()
    {

        if (!isset(self::$worldNpcsCollection)) {
            $config = $this->getConfig();
            $collection = $config['worldNpcsCollection'];
            self::$worldNpcsCollection = $this->getConnection()->selectDB(self::$config['Definitions'])->$collection;
        }

        return self::$worldNpcsCollection;
    }

    public function getItemDefinitionsCollection()
    {

        if (!isset(self::$itemDefinitionsCollection)) {
            $config = $this->getConfig();
            $collection = $config['itemDefinitionsCollection'];
            self::$itemDefinitionsCollection = $this->getConnection()->selectDB(self::$config['Definitions'])->$collection;
        }

        return self::$itemDefinitionsCollection;
    }

    public function getShopsCollection()
    {

        if (!isset(self::$shopsCollection)) {
            $config = $this->getConfig();
            $collection = $config['shopsCollection'];
            self::$shopsCollection = $this->getConnection()->selectDB(self::$config['Definitions'])->$collection;
        }

        return self::$shopsCollection;
    }

    public function getLogsCollection()
    {

        if (!isset(self::$logsCollection)) {
            $config = $this->getConfig();
            $collection = $config['logsCollection'];
            self::$logsCollection = $this->getConnection()->selectDB(self::$config['logsDB'])->$collection;
        }

        return self::$logsCollection;
    }

    public function getCharactersCollection()
    {

        if (!isset(self::$charactersCollection)) {
            $config = $this->getConfig();
            $collection = $config['charactersCollection'];
            self::$charactersCollection = $this->getConnection()->selectDB(self::$config['mainDB'])->$collection;
        }

        return self::$charactersCollection;
    }

    public function getNpcDropsCollection()
    {

        if (!isset(self::$npcDropsCollection)) {
            $config = $this->getConfig();
            $collection = $config['npcDropsCollection'];
            self::$npcDropsCollection = $this->getConnection()->selectDB(self::$config['definitionsDB'])->$collection;
        }

        return self::$npcDropsCollection;
    }

    public function getIpCollection()
    {

        if (!isset(self::$ipCollection)) {
            $config = $this->getConfig();
            $collection = $config['ipCollection'];
            self::$ipCollection = $this->getConnection()->selectDB(self::$config['logsDB'])->$collection;
        }

        return self::$ipCollection;
    }

    public function getPunishmentsCollection()
    {

        if (!isset(self::$punishmentsCollection)) {
            $config = $this->getConfig();
            $collection = $config['punishmentsCollection'];
            self::$punishmentsCollection = $this->getConnection()->selectDB(self::$config['logsDB'])->$collection;
        }

        return self::$punishmentsCollection;
    }


}