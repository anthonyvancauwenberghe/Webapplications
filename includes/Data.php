<?php

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

    private function getDatabaseInfo()
    {
        return Database::getDatabaseInfoConfig();
    }

    private function getReadPreference()
    {
        return Database::getReadPreference();
    }

    protected function aggregate($collectionLocation, $pipeline, $options=null)
    {
        $collection = $this->getCollection($collectionLocation);

        if(isset($options)){
            $cursor = $collection->aggregate($pipeline, $options);
        }
        else{
            $cursor = $collection->aggregate($pipeline);
        }

        return $cursor;
    }

    protected function deleteOne($collectionLocation, $filter){

        $collection = $this->getCollection($collectionLocation);
        
        $collection->deleteOne($filter);
}

    protected function count($collectionLocation, $filter, $options = null)
    {
        $collection = $this->getCollection($collectionLocation);

        if (isset($options)) {
            $count = $collection->count($filter, $options);
        } else {
            $count = $collection->count($filter);
        }

        return $count;
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
    protected function findOne($collectionLocation, $filter, $options = null)
    {
        $collection = $this->getCollection($collectionLocation);

        if (isset($options)) {
            $cursor = $collection->findOne($filter, $options);
        } else {
            $cursor = $collection->findOne($filter);
        }

        return $cursor;
    }

    protected function insertOne($collectionLocation, $document, $options = null){
        
        $collection = $this->getCollection($collectionLocation);

        if (isset($options)) {
            $collection->insertOne($document, $options);
        } else {
            $collection->insertOne($document);
        }

    }

    private function extractDatabaseName($collectionLocation)
    {
        $config = $this->getDatabaseInfo();
        $collection = $config[$collectionLocation];
        $dbName = current(explode(".", $collection));
        return $dbName;
    }

    private function extractCollectionName($collectionLocation)
    {
        $config = $this->getDatabaseInfo();
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