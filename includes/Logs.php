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

        if (!isset($username)) {

            $query = [
                ['$match' => ['log-type' => 'player-value-log']],
                ['$sort' => ['time' => -1]],
                ['$group' => ['_id' => '$content.user.player-name', 'coins' => ['$last' => '$content.value.coins'], 'donator-points' => ['$last' => '$content.value.donator-points']]]
            ];

            $cursor = $this->data->aggregate(Collection::CHARACTERS, $query);

            var_dump($cursor->toArray());
            $i = 0;

            foreach ($cursor as $item) {

                $playerArray[$i] = array(

                    0 => ((string)$item['_id']),
                    1 => ((int)($item['coins'])/1000000),
                    2 => ((int)($item['donator-points'])));
                $i++;
            }


        } else {

        }

        var_dump($playerArray);

    }

}