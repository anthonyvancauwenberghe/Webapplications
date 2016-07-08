<?php
require_once('../libs/AutoLoader.php');

class ServerData extends Data
{

    /**
     * @return Current PlayerCount
     */
    public function getPlayersOnline()
    {
        return $this->count(Collection::CHARACTERS, ['status.online' => true]);
    }

    /**
     * @return Playercount By Country Array
     */
    public function getPlayercountByCountry()
    {
        $cursor = $this->find(Collection::CHARACTERS, ['status.online' => true]);

        $i = 0;
        $countryArray = array();
        $arrays = array();
        foreach ($cursor as $document) {
            $arrays[$i] = $this->getIpLocation($document['last-ip']['ip-address']);
            $i++;
        }

        $newarray = array_count_values($arrays);
        $k = 0;
        while ($country_code = current($newarray)) {
            $countryArray[$k]['code'] = key($newarray);
            $countryArray[$k]['z'] = $country_code;
            next($newarray);
            $k++;
        }
        return json_encode($countryArray);
    }

    /**
     * @return PlayerCountData Array
     */
    public function getPlayercountData()
    {
        // TODO SORT THE FUCKING ARRAY PROPERLY
        $cursor = $this->find(Collection::LOGS, (array('log-type' => 'player-count-log')))->sort(array("time" => 1));
        //$cursor -> limit(50);

        $i = 0;

        foreach ($cursor as $item) {

            $playercountArray[$i] = array(

                0 => ($item['time']->sec) * 1000,
                1 => $item['content']['amount']

            );
            $i++;
        }


        return json_encode($playercountArray);
    }

    function avgOnlineHourData($hours)
    {

        $query = [['$match' => ['log-type' => 'player-count-log']], ['$project' => ['year' => ['$year' => '$time'], 'dayOfYear' => ['$dayOfYear' => '$time'], 'hour' => ['$hour' => '$time'], 'content.amount' => 1]], ['$group' => ['_id' => ['year' => '$year', 'dayOfYear' => '$dayOfYear', 'hour' => '$hour'], 'average' => ['$avg' => '$content.amount']]], ['$sort' => ['year' => -1, 'dayOfYear' => -1, 'hour' => -1]], ['$limit' => $hours]];
        $data = $this->aggregate(Collection::LOGS, $query);
        $avgData = array();
        foreach ($data as $document) {
            $avgData = array_push($avgData, round($document['average'], 0));

        }
        return json_encode($avgData);
    }

    /**
     * @return Average PlayerCount Last x Days
     */
    function avgOnlineDayData($days = 30)
    {

        $query = array(array('$match' => array(
            'log-type' => 'player-count-log'
        )),
            array('$project' => array(
                'day' => array(
                    '$dayOfYear' => '$time'
                ),
                'year' => array('$year' => '$time'),
                'amount' => '$content.amount',
                'time' => 1
            )
            ),
            array(
                '$group' => array('_id' => array('year' => '$year', 'day' => '$day'), 'amount' => array('$avg' => '$amount'))
            ),
            array('$sort' => array('_id.year' => -1)),
            array('$sort' => array('_id.day' => 1)),
            array('$limit' => $days));

        $data = $this->aggregate('logsCollection', $query);

        foreach ($data as $document) {
            if (isset($avgData)) {
                $avgData = $avgData . ', ' . round($document['amount'], 0);
            } else {
                $avgData = round($document['amount'], 0);
            }

        }
        return $avgData;
    }

    function maxOnlineDayData($days)
    {

        $query = array(array('$match' => array(
            'log-type' => 'player-count-log'
        )),
            array('$project' => array(
                'day' => array(
                    '$dayOfYear' => '$time'
                ),
                'year' => array('$year' => '$time'),
                'amount' => '$content.amount',
                'time' => 1
            )
            ),
            array(
                '$group' => array('_id' => array('year' => '$year', 'day' => '$day'), 'amount' => array('$max' => '$amount'))
            ),
            array('$sort' => array('_id.year' => -1)),
            array('$sort' => array('_id.day' => 1)),
            array('$limit' => $days));
        $data = $this->getLogsCollection()->aggregateCursor($query);

        foreach ($data as $document) {
            if (isset($maxData)) {
                $maxData = $maxData . ', ' . round($document['amount'], 0);
            } else {
                $maxData = round($document['amount'], 0);
            }

        }
        return $maxData;
    }

    function minOnlineDayData($days)
    {

        $query = array(array('$match' => array(
            'log-type' => 'player-count-log'
        )),
            array('$project' => array(
                'day' => array(
                    '$dayOfYear' => '$time'
                ),
                'year' => array('$year' => '$time'),
                'amount' => '$content.amount',
                'time' => 1
            )
            ),
            array(
                '$group' => array('_id' => array('year' => '$year', 'day' => '$day'), 'amount' => array('$min' => '$amount'))
            ),
            array('$sort' => array('_id.year' => -1)),
            array('$sort' => array('_id.day' => 1)),
            array('$limit' => $days));
        $data = $this->getLogsCollection()->aggregateCursor($query);

        foreach ($data as $document) {
            if (isset($minData)) {
                $minData = $minData . ', ' . round($document['amount'], 0);
            } else {
                $minData = round($document['amount'], 0);
            }

        }
        return $minData;
    }

    function newlyCreatedCharactersDayData($days)
    {

        $query = [['$match' => ['log-type' => 'new-character-log']],
            ['$project' => ['dayOfYear' => ['$dayOfYear' => '$time'], 'year' => ['$year' => '$time'], 'month' => ['$month' => '$time'], 'day' => ['$dayOfMonth' => '$time'], 'time' => 1]],
            ['$group' => ['_id' => ['year' => '$year', 'month' => '$month', 'day' => '$day'], 'amount' => ['$sum' => 1]]],
            ['$sort' => ['_id.year' => -1, '_id.month' => -1, '_id.day' => -1]],
            ['$limit' => $days]];

        $data = $this->getLogsCollection()->aggregateCursor($query);

        for ($day = 0; $day < $days; $day++) {
            $avgData[$day] = 0;
        }

        foreach ($data as $document) {
            $avgData[$document['_id']['day'] - 1] = (int)round($document['amount'], 0);
        }
        for ($i = 0; $i < $days; $i++) {
            if (isset($dataOut)) {
                $dataOut = $dataOut . ', ' . $avgData[$i];
            } else {
                $dataOut = $avgData[$i];
            }
        }
        return $dataOut;
    }

    /**
     * @return Average PlayerCount Today
     */
    function averagePlayercountToday()
    {

        $query = array(array('$match' => array(
            'log-type' => 'player-count-log'
        )),
            array('$project' => array(
                'day' => array(
                    '$dayOfYear' => '$time'
                ),
                'year' => array('$year' => '$time'),
                'amount' => '$content.amount',
                'time' => 1
            )
            ),
            array(
                '$group' => array('_id' => array('year' => '$year', 'day' => '$day'), 'amount' => array('$avg' => '$amount'))
            ),
            array('$sort' => array('_id.year' => -1)),
            array('$sort' => array('_id.day' => -1)),
            array('$limit' => 1));
        $data = $this->getLogsCollection()->aggregateCursor($query);

        foreach ($data as $document) {
            $avgPlayercount = round($document['amount'], 2);
        }


        return $avgPlayercount;
    }

    function maxPlayercountToday()
    {

        $query = array(array('$match' => array(
            'log-type' => 'player-count-log'
        )),
            array('$project' => array(
                'day' => array(
                    '$dayOfYear' => '$time'
                ),
                'year' => array('$year' => '$time'),
                'amount' => '$content.amount',
                'time' => 1
            )
            ),
            array(
                '$group' => array('_id' => array('year' => '$year', 'day' => '$day'), 'amount' => array('$max' => '$amount'))
            ),
            array('$sort' => array('_id.year' => -1)),
            array('$sort' => array('_id.day' => -1)),
            array('$limit' => 1));
        $data = $this->$this->getLogsCollection()->aggregateCursor($query);

        foreach ($data as $document) {
            $maxPlayercount = round($document['amount'], 2);
        }


        return $maxPlayercount;
    }

    function minPlayercountToday()
    {

        $query = array(array('$match' => array(
            'log-type' => 'player-count-log'
        )),
            array('$project' => array(
                'day' => array(
                    '$dayOfYear' => '$time'
                ),
                'year' => array('$year' => '$time'),
                'amount' => '$content.amount',
                'time' => 1
            )
            ),
            array(
                '$group' => array('_id' => array('year' => '$year', 'day' => '$day'), 'amount' => array('$min' => '$amount'))
            ),
            array('$sort' => array('_id.year' => -1)),
            array('$sort' => array('_id.day' => -1)),
            array('$limit' => 1));
        $data = $this->getLogsCollection()->aggregateCursor($query);

        foreach ($data as $document) {
            $minPlayercount = round($document['amount'], 2);
        }

        return $minPlayercount;
    }

    function countCharacters()
    {
        return $this->getCharactersCollection()->count();
    }

    function getJavaErrors($amount)
    {

        $query = array('log-type' => 'error-log');
        $cursor = $this->getLogsCollection()->find($query);

        if ($amount > 0) {
            $cursor->limit($amount);
        }

        $i = 0;
        foreach ($cursor as $document) {
            $errors[$i]['time'] = convertToTime($document['time']);
            $errors[$i]['message'] = $document['content']['message'];
            $errors[$i]['cause'] = $document['content']['cause'];
            $errors[$i]['stack-trace'] = $document['content']['stack-trace'];
        }

        return json_encode($errors);
    }

    function getDonatorWealthData()
    {

        $query = array('log-type' => 'server-wealth-log');
        $cursor = $this->getLogsCollection()->find($query)->sort(array("time" => 1));

        $i = 0;

        foreach ($cursor as $item) {

            $wealthArray[$i] = array(

                0 => ($item['time']->sec) * 1000,
                1 => ((int)($item['content']['donator-points']->value / 100)));
            $i++;
        }

        return json_encode($wealthArray);
    }

    function getGPWealthData()
    {
        $query = array('log-type' => 'server-wealth-log');
        $cursor = $this->getLogsCollection()->find($query)->sort(array("time" => 1));

        $i = 0;

        foreach ($cursor as $item) {

            $wealthArray[$i] = array(

                0 => ($item['time']->sec) * 1000,
                1 => ((int)($item['content']['coins']->value / 1000000)));
            $i++;
        }

        return json_encode($wealthArray);
    }
    
    function ServerStatus() {
        $fp = @fsockopen('gameserver.deviousps.com', 13377, $errno, $errstr, 0.5);
        if (!$fp) {
            return 'Offline';
        } else {
            return 'Online';
            fclose($fp);
        }
    }
}
