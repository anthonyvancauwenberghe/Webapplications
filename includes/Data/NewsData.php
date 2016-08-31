<?php
/**
 * Created by PhpStorm.
 * User: Lukafurlan
 * Date: 8/30/2016
 * Time: 6:32 PM
 */

class NewsData extends Data {

    /**
     * @param $data
     */
    public function updateNews($data)
    {
        $this->insertOne(Collection::CONFIG, array(array("config-type" => "newsConfig"), array('$set' => array("content" => $data))));
    }
}