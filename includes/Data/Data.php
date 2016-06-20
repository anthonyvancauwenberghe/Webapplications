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

    /**
     * @return Core
     */
    protected static function getCoreFunctions()
    {
        if (!isset(self::$Core)) {
            self::$core = new Core();
        }
        return self::$core;
    }


    private function getConnection()
    {
        return Database::connect();
    }

    private function getConfig()
    {
        return Database::getConfig();
    }

    private function getReadPreference()
    {
        return Database::getReadPreference();
    }

    protected function aggregate($collectionLocation, $pipeline)
    {
        $collection = $this->getCollection($collectionLocation);

        $cursor = $collection->aggregate($pipeline);
        return $cursor;
    }

    protected function find($collectionLocation, $filter, $options = null)
    {
        $collection = $this->getCollection($collectionLocation);

        if (isset($options)) {
            $cursor = $collection->find($filter, $options);
        } else {
            $cursor = $collection->find($filter);
        }

        return $cursor;
    }


    private function extractDatabaseName($collectionLocation)
    {
        $config = $this->getConfig();
        $collection = $config[$collectionLocation];
        $dbName = current(explode(".", $collection));
        return $dbName;
    }

    private function extractCollectionName($collectionLocation)
    {
        $config = $this->getConfig();
        $collection = $config[$collectionLocation];
        $collectionName = substr($collection, strpos($collection, ".") + 1);
        return $collectionName;
    }

    private function getCollection($collectionLocation)
    {
        $collection = $this->getConnection()->selectCollection($this->extractDatabaseName($collectionLocation), $this->extractCollectionName($collectionLocation));
        return $collection;
    }

}