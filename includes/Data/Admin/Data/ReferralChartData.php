<?php

class ReferralChartData extends Admin
{

    public function getCursor($week=null, $month=null, $year=null)
    {
        if(isset($week)){
            $query = [
                ['$match'=> ['type'=> 'GET_Referral']],
                ['$project'=> [
                    'ref'=> '$content.ref',
                    'year'=> ['$year'=> '$time'],
                    'month'=> ['$month'=> '$time'],
                    'week'=> ['$week'=> '$time'],
                ]],
                ['$match'=> ['week'=>$week]],
                ['$group'=> ['_id'=> '$ref', 'amount'=> ['$sum'=> 1]]],
                ['$sort'=> ['amount'=> -1]]
            ];
        }
        elseif(isset($month)){
            $query = [
                ['$match'=> ['type'=> 'GET_Referral']],
                ['$project'=> [
                    'ref'=> '$content.ref',
                    'year'=> ['$year'=> '$time'],
                    'month'=> ['$month'=> '$time'],
                    'week'=> ['$week'=> '$time'],
                ]],
                ['$match'=> ['month'=>$month]],
                ['$group'=> ['_id'=> '$ref', 'amount'=> ['$sum'=> 1]]],
                ['$sort'=> ['amount'=> -1]]
            ];
        }
        elseif(isset($year)){
           $query = [
                ['$match'=> ['type'=> 'GET_Referral']],
                ['$project'=> [
                    'ref'=> '$content.ref',
                    'year'=> ['$year'=> '$time'],
                    'month'=> ['$month'=> '$time'],
                    'week'=> ['$week'=> '$time'],
                ]],
                ['$match'=> ['year'=>$year]],
                ['$group'=> ['_id'=> '$ref', 'amount'=> ['$sum'=> 1]]],
               ['$sort'=> ['amount'=> -1]]
            ];
        }
        else {
            $query = [
                ['$match'=> ['type'=> 'GET_Referral']],
                ['$project'=> [
                    'ref'=> '$content.ref',
                    'year'=> ['$year'=> '$time'],
                    'month'=> ['$month'=> '$time'],
                    'week'=> ['$week'=> '$time'],
                ]],
                ['$group'=> ['_id'=> '$ref', 'amount'=> ['$sum'=> 1]]],
                ['$sort'=> ['amount'=> -1]]
            ];
        }
        
        $cursor = $this->aggregate(Collection::MARKETING, $query);

        return $cursor;
    }

}