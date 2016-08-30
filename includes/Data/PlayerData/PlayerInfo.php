<?php
require_once('../libs/AutoLoader.php');


class PlayerInfo extends PlayerData
{
    private $playerName;
    private $deaths;
    private $kills;
    private $kdr;
    private $playTime;
    private $GPWealth;
    private $DPWealth;
    private $GPWealthData;
    private $DPWealthData;
    private $playTimeWeek;
    private $topPVMKills;

    private $totalLevel;
    private $totalExperience;
    private $combatLevel;

    private $skills = array();

    public function __construct($name)
    {
        $this->playerName = $name;
        $this->setPlayerInfo();
    }

    private function setPlayerInfo()
    {
        $query = [['$match' => ['log-type' => 'login-log']],
            ['$match' => ['content.user.player-name' => $this->playerName]],
            ['$sort' => ['time' => -1]],
            ['$limit' => 1],
            ['$project' => ['_id' => 0, 'kills' => '$content.kills', 'deaths' => '$content.deaths', 'playTime' => '$content.playTime', 'skills' => '$content.skills']]];

        $playerInfo = $this->aggregate(Collection::LOGS, $query)->toArray();

        $query = [
            ['$match' => ['log-type' => 'player-value-log']],
            ['$match' => ['content.user.player-name' => $this->playerName]],
            ['$sort' => ['time' => -1]],
            ['$limit' => 1],
            ['$project' => ['_id' => 0, 'coins' => '$content.value.coins', 'donatorPoints' => '$content.value.donator-points']]];

        $wealthInfo = $this->aggregate(Collection::LOGS, $query)->toArray();

        $this->kills = $playerInfo[0]['kills'];
        $this->deaths = $playerInfo[0]['deaths'];
        $this->deaths > 0 ? $this->kdr = round($this->kills / $this->deaths, 3) : $this->kdr = 0;
        $this->playTime = $playerInfo[0]['playTime'];
        $this->skills = $playerInfo[0]['skills'];
        $this->GPWealth = isset($wealthInfo[0]['coins']) ? $wealthInfo[0]['coins'] : 0;
        $this->DPWealth = isset($wealthInfo[0]['donatorPoints']) ? $wealthInfo[0]['donatorPoints'] : 0;
        $this->setSumLevels();
        $this->setWealthData();
        $this->setPlayTimeWeek();
        $this->setTopPVMKills();
    }

    private function setSumLevels()
    {
        $totalLevel = 0;
        $totalExperience = 0;
        foreach ($this->skills as $skill) {
            $totalLevel = $totalLevel + $this->getMaxSkillLevel($skill['name']);
            $totalExperience = $totalExperience + $skill['experience'];
        }
        $this->totalLevel = $totalLevel;
        $this->totalExperience = $totalExperience;
        $this->combatLevel = $this->calculateCombatLevel();
    }

    private function getMaxSkillLevel($skillName)
    {
        $a = 0;
        for ($x = 1; $x < 99; $x++) {
            $a += floor($x + 300 * pow(2, ($x / 7)));
            if (floor($a / 4) > $this->skills[$skillName]['experience']) {
                break;
            }
        }
        return $x;
    }

    private function calculateCombatLevel()
    {
        $base = 0.25 * ($this->getMaxSkillLevel('DEFENCE') + $this->getMaxSkillLevel('CONSTITUTION') + floor($this->getMaxSkillLevel('PRAYER') / 2) + floor($this->getMaxSkillLevel('SUMMONING') / 2));
        $melee = 0.325 * ($this->getMaxSkillLevel('ATTACK') + $this->getMaxSkillLevel('STRENGTH'));
        $range = 0.325 * (floor($this->getMaxSkillLevel('RANGED') / 2) + $this->getMaxSkillLevel('RANGED'));
        $mage = 0.325 * (floor($this->getMaxSkillLevel('MAGIC') / 2) + $this->getMaxSkillLevel('MAGIC'));
        $combatLevel = floor($base + max([$melee, $range, $mage]));
        return (int)$combatLevel;
    }

    /**
     * @param mixed $wealthData
     */
    private function setWealthData()
    {
        $query = [
            ['$match' => ['log-type' => 'player-value-log']],
            ['$match' => ['content.user.player-name' => $this->playerName]],
            ['$project' => ['_id' => '$time', 'gp' => '$content.value.coins', 'dp' => '$content.value.donator-points']],
            ['$sort' => ['time' => -1]]
        ];
        $wealthArray = $this->aggregate(Collection::LOGS, $query)->toArray();
        $i = 0;
        foreach ($wealthArray as $document) {
            $GPWealth[$i][0] = $this->getCoreFunctions()->convertToUnixTimestamp($document['_id']) * 1000;
            $GPWealth[$i][1] = round($document['gp'] / 1000000, 2);

            $DPWealth[$i][0] = $GPWealth[$i][0];
            $DPWealth[$i][1] = round($document['dp'] / 100, 2);
            $i++;
        }
        if (isset($GPWealth)) {
            $this->GPWealthData = json_encode($GPWealth);
        } else {
            $this->GPWealthData = null;
        }
        if (isset($DPWealth)) {
            $this->DPWealthData = json_encode($DPWealth);
        } else {
            $this->DPWealthData = null;
        }


    }

    private function setPlayTimeWeek()
    {
        /*
        $query1 = [
            ['$match'=> ['log-type'=> 'login-log']],
            ['$match'=> ['content.user.player-name'=> 'Plum 95']],
            ['$match'=> ['time'=> ['$lt'=> new MongoDB\BSON\UTCDateTime(time())]]],
            ['$sort'=> ['time'=> -1]],
            ['$limit'=> 1]
        ];
        
        $query2 = [
            ['$match'=> ['log-type'=> 'login-log']],
            ['$match'=> ['content.user.player-name'=> 'Plum 95']],
            ['$sort'=> ['time'=> -1]],
            ['$limit'=> 1]
        ];

        $time1 = $this->aggregate(Collection::LOGS, $query1)->toArray();
        print_r($time1);
        $time2 = $this->aggregate(Collection::LOGS, $query2)->toArray();

        $time = $this->getCoreFunctions()->convertToUnixTimestamp($time1['time3'])- $this->getCoreFunctions()->convertToUnixTimestamp($time2['time2']);
        */
        $this->playTimeWeek = 0;
    }

    /**
     * @return mixed
     */
    public function getTopPVMKills()
    {
        return $this->topPVMKills;
    }

    /**
     * @param mixed $topPVMKills
     */
    public function setTopPVMKills()
    {
        $query = [
            ['$match' => ['log-type' => 'kill-log']],
            ['$match' => ['content.user-2.player-name' => $this->playerName]],
            ['$group' => ['_id' => '$content.user.npc-name', 'amount' => ['$sum' => 1]]],
            ['$sort' => ['amount' => -1]],
            ['$limit' => 5]
        ];

        $topPVMKills = $this->aggregate(Collection::LOGS, $query)->toArray();


        $this->topPVMKills = $topPVMKills;
    }

    public function getLatestDuelKills()
    {
        $query = [
            ['$match' => ['log-type' => 'duel-arena-log']],
            ['$match' => ['$or' => [['content.loser.player-name' => $this->playerName], ['content.winner.player-name' => $this->playerName]]]],
            ['$sort' => ['time' => -1]],
            ['$limit' => 5]
        ];

        $latestDuelKills = $this->aggregate(Collection::LOGS, $query)->toArray();

        return $latestDuelKills;
    }



    /**
     * @return mixed
     */
    public function getKills()
    {
        return $this->kills;
    }

    /**
     * @return mixed
     */
    public function getDeaths()
    {
        return $this->deaths;
    }

    /**
     * @return mixed
     */
    public function getKdr()
    {
        return $this->kdr;
    }

    /**
     * @return mixed
     */
    public function getTotalLevel()
    {
        return $this->totalLevel;
    }

    /**
     * @return mixed
     */
    public function getTotalExperience()
    {
        return $this->totalExperience;
    }

    /**
     * @return mixed
     */
    public function getCombatLevel()
    {
        return $this->combatLevel;
    }

    /**
     * @return mixed
     */
    public function getPlayTime()
    {
        return round($this->playTime / (1000 * 60 * 60 * 24), 2);
    }

    /**
     * @return mixed
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @return mixed
     */
    public function getGPWealth()
    {
        return $this->GPWealth;
    }

    /**
     * @return mixed
     */
    public function getDPWealth()
    {
        return $this->DPWealth;
    }

    public function getGPWealthData()
    {
        return $this->GPWealthData;
    }

    public function getDPWealthData()
    {
        return $this->DPWealthData;
    }

    /**
     * @return mixed
     */
    public function getPlayTimeWeek()
    {
        return $this->playTimeWeek;
    }
    
    private function getSkillExperience($skillName)
    {
        return $this->skills[$skillName]['experience'];
    }

}