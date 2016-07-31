<?php
require_once('../libs/AutoLoader.php');


class PlayerInfo extends PlayerData
{
    private $playerName;
    private $deaths;
    private $kills;
    private $kdr;
    private $playTime;

    private $totalLevel;
    private $totalExperience;
    private $combatLevel;

    private $skills = array();

    public function __construct($name)
    {
        $this->playerName = $name;
        $this->setSkillsKDRInfo();
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

    private function setSkillsKDRInfo()
    {
        $query = [['$match' => ['log-type' => 'login-log']],
            ['$match' => ['content.user.player-name' => $this->playerName]],
            ['$sort' => ['time' => -1]],
            ['$limit' => 1],
            ['$project' => ['_id' => 0, 'kills' => '$content.kills', 'deaths' => '$content.deaths', 'playTime' => '$content.playTime', 'skills' => '$content.skills']]];

        $playerInfo = $this->aggregate(Collection::LOGS, $query)->toArray();

        $this->kills = $playerInfo[0]['kills'];
        $this->deaths = $playerInfo[0]['deaths'];
        $this->deaths > 0 ? $this->kdr = round($this->kills / $this->deaths, 2) : $this->kdr = 0;
        $this->playTime = $playerInfo[0]['playTime'];
        $this->skills = $playerInfo[0]['skills'];

        $this->setSumLevels();
    }

    private function setSumLevels()
    {
        foreach ($this->skills as $skill) {
            $totalLevel = +$skill['level'];
            $totalExperience = +$skill['experience'];
        }
        $this->totalLevel = $totalLevel;
        $this->totalExperience = $totalExperience;
        $this->combatLevel = $this->calculateCombatLevel();
    }

    private function getMaxSkillLevel($skillName)
    {
        $a = 0;
        for ($x = 1; $x < 100; $x++) {
            $a += floor($x + 300 * pow(2, ($x / 7)));
            if (floor($a / 4) >= $this->skills[$skillName]['experience']) {
                break;
            }

        }
        return $x;
    }


    private function getSkillExperience($skillName)
    {
        return $this->skills[$skillName]['experience'];
    }

    private function calculateCombatLevel()
    {
        $base = 0.25 * ($this->getMaxSkillLevel('DEFENCE') + $this->getMaxSkillLevel('CONSTITUTION') + floor($this->getMaxSkillLevel('PRAYER') / 2)) + floor($this->getMaxSkillLevel('SUMMONING') / 2);
        $melee = 0.325 * ($this->getMaxSkillLevel('ATTACK') + $this->getMaxSkillLevel('STRENGTH'));
        $range = 0.325 * (floor($this->getMaxSkillLevel('RANGED') / 2) + $this->getMaxSkillLevel('RANGED'));
        $mage = 0.325 * (floor($this->getMaxSkillLevel('MAGIC') / 2) + $this->getMaxSkillLevel('MAGIC'));
        $combatLevel = floor($base + max([$melee, $range, $mage]));
        return (int)$combatLevel;
    }

}