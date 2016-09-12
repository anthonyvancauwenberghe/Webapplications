<?php

class MarketingInfo extends AdminData
{

    public function getMarketingData()
    {

        $query = [
            ['$match'=> ['type'=> 'GET_Referral']],
            ['$project'=> [
                'year'=> ['$year'=> '$time'],
                'month'=> ['$month'=> '$time'],
                'day'=> ['$dayOfMonth'=> '$time'],
                'refName'=> '$content.ref'
            ]
            ],
            ['$group'=> [
                '_id'=> ['refName'=> '$refName', 'year'=> '$year', 'month'=> '$month', 'day'=> '$day'],
                'count'=> ['$sum'=> 1],
            ]],
            ['$sort'=> ['_id.year'=> 1, '_id.month'=> 1, '_id.day'=> 1]],
            ['$group'=> ['_id'=> '$_id.refName', 'amounts'=> ['$push'=> ['year'=> '$_id.year', 'month'=> '$_id.month', 'day'=> '$_id.day', 'amount'=> '$count']]]]
        ];
        
        $marketingArray = $this->aggregate(Collection::MARKETING, $query)->toarray();

        return $marketingArray;
    }

}