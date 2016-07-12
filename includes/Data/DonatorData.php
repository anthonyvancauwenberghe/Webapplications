<?php
require_once('../libs/AutoLoader.php');

class DonatorData extends Data
{

    function avgDonationsHourData()
    {

        $query = [['$project' => ['year' => ['$year' => '$time'], 'month' => ['$month' => '$time'], 'day' => ['$dayOfMonth' => '$time'], 'hour' => ['$hour' => '$time'], 'purchase.profit' => 1]],
            ['$match' => ['$and' => [['year' => $this->getCoreFunctions()->getDateof('y')], ['month' => $this->getCoreFunctions()->getDateof('m')], ['day' => $this->getCoreFunctions()->getDateof('d')]]]],
            ['$group' => ['_id' => '$hour', 'average' => ['$sum' => '$purchase.profit']]],
            ['$sort' => ['hour' => -1]]];

        $cursor = $this->aggregate(Collection::DONATIONS, $query);

        for ($hour = 0; $hour < 24; $hour++) {
            $DonationsHourData[$hour] = 0;
        }

        foreach ($cursor as $document) {
            $DonationsHourData[$document['_id'] - 1] = (int)round($document['average'], 2);
        }

        var_dump(json_encode($DonationsHourData));
    }
    
    function donationCountToday()
    {
        $query = [
            ['$project' => [
                'dayOfYear' => ['$dayOfYear' => '$time'],
                'year' => ['$year' => '$time'],
                'month' => ['$month' => '$time'],
                'day' => ['$dayOfMonth' => '$time'],
                'profit' => '$purchase.profit',
                'time' => 1,
            ]
            ],
            [
                '$match' => ['$and' => [
                    ['year' => $this->getCoreFunctions()->getDateof('y')],
                    ['month' => $this->getCoreFunctions()->getDateof('m')],
                    ['day' => $this->getCoreFunctions()->getDateof('d')]
                ]]
            ],
            [
                '$group' => [
                    '_id' => 'donations-today',
                    'total' => ['$sum' => '$profit'],
                    'count' => ['$sum' => 1]
                ]
            ]];
        $data = $this->getDonationsCollection()->aggregateCursor($query);

        foreach ($data as $document) {
            $count = $document['count'];
        }
        if (!isset($count))
            $profit = 0;

        return $count;
    }
    
    function donationProfitToday()
    {
        $query = [
            ['$project' => [
                'dayOfYear' => ['$dayOfYear' => '$time'],
                'year' => ['$year' => '$time'],
                'month' => ['$month' => '$time'],
                'day' => ['$dayOfMonth' => '$time'],
                'profit' => '$purchase.profit',
                'time' => 1,
            ]
            ],
            [
                '$match' => ['$and' => [
                    ['year' => $this->getCoreFunctions()->getDateof('y')],
                    ['month' => $this->getCoreFunctions()->getDateof('m')],
                    ['day' => $this->getCoreFunctions()->getDateof('d')]
                ]]
            ],
            [
                '$group' => [
                    '_id' => 'donations-today',
                    'total' => ['$sum' => '$profit'],
                    'count' => ['$sum' => 1]
                ]
            ]];
        $data = $this->getDonationsCollection()->aggregateCursor($query);

        foreach ($data as $document) {
            $profit = $document['total'];
        }
        if (!isset($profit))
            $profit = 0;

        return $profit;
    }
}


?>