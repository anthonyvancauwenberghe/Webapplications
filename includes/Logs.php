<?php

require_once '../libs/AutoLoader.php';

class Logs
{
    private $data;

    public function getAccountvalue($username = null)
    {
        if (!isset($this->data)) {
            $this->data = new Data();
        }




                $match = ['$match' => ['log-type' => 'player-value-log']];
                $group = [  '$group' => [ '_id' => '$content.user.player-name',
                            'coins' => ['$first' => '$content.value.coins'],
                            'donator-points' => ['$first' => '$content.value.donator-points']]];
                $sort = ['$sort' => ['time' => -1]];


            $cursor = $this->data->aggregate(Collection::LOGS, $match, $group, $sort);

            var_dump($cursor->toArray());
           /* $i = 0;

            foreach ($cursor as $item) {

                $playerArray[$i] = array(

                    0 => ((string)$item['_id']),
                    1 => ((int)($item['coins'])/1000000),
                    2 => ((int)($item['donator-points'])));
                $i++;
            }

*/


        //var_dump($playerArray);

    }

}