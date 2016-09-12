<?php


class ObjectCreator
{

    private $serverData;
    private $NPCData;
    private $objectsData;

    public function getServerData()
    {
        if (!isset($this->serverData)) {
            $this->serverData = new ServerData();
        }
        return $this->serverData;
    }

    public function getObjectsData()
    {
        if (!isset($this->objectsData)) {
            $this->objectsData = new ObjectsData();
        }
        return $this->objectsData;
    }

    public function getNPCData()
    {
        if (!isset($this->NPCData)) {
            $this->NPCData = new NPCData();
        }
        return $this->NPCData;
    }

}