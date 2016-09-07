<?php

class MarketingInfo extends ServerData
{

    public function getMarketingData()
    {
        $dayNumber = $this->getCoreFunctions()->getDayNumber();
        $monthNumber = $this->getCoreFunctions()->getMonthNumber();
        $yearNumber = $this->getCoreFunctions()->getYearNumber();

        $query = [
            ['$project' => [
                'year' => ['$year' => '$time'],
                'month' => ['$month' => '$time'],
                'day' => ['$dayOfMonth' => '$time'],
                'refName' => '$content.refName'
            ]
            ],
            ['$match' => [
                'year' => $yearNumber,
                'month' => $monthNumber,
                'day' => $dayNumber,
            ]],
            ['$group' => ['_id' => 'refName', 'count' => ['$sum', 1]]]
        ];


    }

}