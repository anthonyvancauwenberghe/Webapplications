<?php
require_once('../libs/AutoLoader.php');

class ObjectsData extends Data
{


    public function getAllObjects(){
        $cursor = $this->find(Collection::OBJECT_DEFINITIONS, array());
        return json_encode($cursor->toArray());
    }
}

