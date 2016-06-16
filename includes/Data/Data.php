<?php
require_once '../libs/AutoLoader.php';

/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 15/06/2016
 * Time: 21:21
 */
class Data
{
    /* Objects */
    private static $core;

    /* DB collections */
    private static $logsCollection;
    private static $donationsCollection;
    private static $votesCollection;
    private static $charactersCollection;
    private static $ipCollection;
    private static $npcDropsCollection;
    private static $npcDefinitionsCollection;
    private static $worldNpcsCollection;
    private static $itemDefinitionsCollection;
    private static $shopsCollection;
    private static $punishmentsCollection;
    
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

    /**
     * @return Core
     */
    protected static function getCoreFunctions()
    {
        if(!isset(self::$Core)){
            self::$core =new Core();
    }
        return self::$core;
    }
    
    

    private function getConnection(){
        return Database::connect();
    }

    private function getConfig()
    {
        return Database::getConfig();
    }

    
    protected function getDonationsCollection()
    {
        if (!isset(self::$donationsCollection)) {
            $config = $this->getConfig();
            $collection = $config['donationsCollection'];
            self::$donationsCollection = $this->getConnection()->selectDB($config['mainDB'])->$collection;
        }

        return self::$donationsCollection;
    }

    protected function getVotesCollection()
    {

        if (!isset(self::$votesCollection)) {
            $config = $this->getConfig();
            $collection = $config['votesCollection'];
            self::$votesCollection = $this->getConnection()->selectDB($config['mainDB'])->$collection;
        }

        return self::$votesCollection;
    }

    protected function geNpcDropsCollection()
    {

        if (!isset(self::$npcDropsCollection)) {
            $config = $this->getConfig();
            $collection = $config['npcDropsCollection'];
            self::$npcDropsCollection = $this->getConnection()->selectDB($config['Definitions'])->$collection;
        }

        return self::$npcDropsCollection;
    }

    protected function getNpcDefinitionsCollection()
    {

        if (!isset(self::$npcDefinitionsCollection)) {
            $config = $this->getConfig();
            $collection = $config['npcDefinitionsCollection'];
            self::$npcDefinitionsCollection = $this->getConnection()->selectDB($config['Definitions'])->$collection;
        }

        return self::$npcDefinitionsCollection;
    }

    protected function getWorldNpcsCollection()
    {

        if (!isset(self::$worldNpcsCollection)) {
            $config = $this->getConfig();
            $collection = $config['worldNpcsCollection'];
            self::$worldNpcsCollection = $this->getConnection()->selectDB($config['Definitions'])->$collection;
        }

        return self::$worldNpcsCollection;
    }

    protected function getItemDefinitionsCollection()
    {

        if (!isset(self::$itemDefinitionsCollection)) {
            $config = $this->getConfig();
            $collection = $config['itemDefinitionsCollection'];
            self::$itemDefinitionsCollection = $this->getConnection()->selectDB($config['Definitions'])->$collection;
        }

        return self::$itemDefinitionsCollection;
    }

    protected function getShopsCollection()
    {

        if (!isset(self::$shopsCollection)) {
            $config = $this->getConfig();
            $collection = $config['shopsCollection'];
            self::$shopsCollection = $this->getConnection()->selectDB($config['Definitions'])->$collection;
        }

        return self::$shopsCollection;
    }

    protected function getLogsCollection()
    {

        if (!isset(self::$logsCollection)) {
            $config = $this->getConfig();
            $collection = $config['logsCollection'];
            self::$logsCollection = $this->getConnection()->selectDB($config['logsDB'])->$collection;
        }

        return self::$logsCollection;
    }

    protected function getCharactersCollection()
    {

        if (!isset(self::$charactersCollection)) {
            $config = $this->getConfig();
            $collection = $config['charactersCollection'];
            self::$charactersCollection = $this->getConnection()->selectDB($config['mainDB'])->$collection;
        }

        return self::$charactersCollection;
    }

    protected function getNpcDropsCollection()
    {

        if (!isset(self::$npcDropsCollection)) {
            $config = $this->getConfig();
            $collection = $config['npcDropsCollection'];
            self::$npcDropsCollection = $this->getConnection()->selectDB($config['definitionsDB'])->$collection;
        }

        return self::$npcDropsCollection;
    }

    protected function getIpCollection()
    {

        if (!isset(self::$ipCollection)) {
            $config = $this->getConfig();
            $collection = $config['ipCollection'];
            self::$ipCollection = $this->getConnection()->selectDB($config['logsDB'])->$collection;
        }

        return self::$ipCollection;
    }

    protected function getPunishmentsCollection()
    {

        if (!isset(self::$punishmentsCollection)) {
            $config = $this->getConfig();
            $collection = $config['punishmentsCollection'];
            self::$punishmentsCollection = $this->getConnection()->selectDB($config['logsDB'])->$collection;
        }

        return self::$punishmentsCollection;
    }


}