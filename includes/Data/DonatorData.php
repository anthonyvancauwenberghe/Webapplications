<?php
include 'Data.php';

class DonatorData extends Data {

	function donationsToday(){
		$query=[
			['$project'=> [
				'dayOfYear'=> ['$dayOfYear'=> '$time'],
				'year'=> ['$year'=> '$time'],
				'month'=> ['$month'=> '$time'],
				'day'=> ['$dayOfMonth'=> '$time'],
				'profit'=> '$purchase.profit',
				'time'=> 1,
			]
			],
			[
				'$match'=> ['$and'=> [
					['year'=> getDateof('y') ],
					['month'=> getDateof('m')],
					['day'=> getDateof('d')]
				]]
			],
			[
				'$group'=> [
					'_id'=> 'donations-today',
					'total'=> ['$sum'=> '$profit'],
					'count'=> ['$sum'=> 1]
				]
			]];
		$data = $this->getDonationsCollection()->aggregateCursor($query);

		foreach($data as $document){
			$profit=$document['total'];
			$count = $document['count'];
		}
		if(!isset($profit))
			$profit=0;

		if(!isset($count))
			$count=0;

		return '<span>Donations Today: ' . $count . '</span>
              <h2>$' . $profit . '</h2>';
	}
}


?>