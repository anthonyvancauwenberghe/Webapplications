<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 2:02
 */
class LoginInfo extends Data
{
    public function getPlayerObjectByName($playerName){
        return $this->findOne(Collection::CHARACTERS, array('player-name' => $playerName));
    }

    public function getPlayerObjectByID($id){
        return $this->findOne(Collection::CHARACTERS, array('_id' => new MongoDB\BSON\ObjectId($id)));
    }

}