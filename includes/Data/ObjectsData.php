<?php
require_once '../AutoLoadClasses.php';

class ObjectsData extends Data
{
    public function getAllObjects(){
        $pipeline = [['$project' => ["_id"=> 0, "objectId"=> 1, "position"=> 1, "orientation"=> 1, "objectType"=> 1]]];
        $cursor = $this->aggregate(Collection::OBJECT_DEFINITIONS, $pipeline);
        return json_encode($cursor->toArray());
    }
}

