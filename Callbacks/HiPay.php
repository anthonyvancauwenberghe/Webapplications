<?php
require_once('../libs/AutoLoader.php');

$hipay=new HiPay();
$hipay->processDonation();

header('Content-Type: text/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>


<response status="1">
    <code><?php echo $hipay->code; ?></code>
    <message><?php echo $hipay->message; ?></message>
</response>