<?php
require_once('../libs/AutoLoader.php');

$bmtparser = new BMTXMLParser ();
$bmtmicro = new BmtMicro();

echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<response>';
echo '<ordernotification>';

if ($bmtparser->parse($HTTP_RAW_POST_DATA)) {
    $bmtmicro->processDonation($bmtparser);
}

else {
    echo '<errorcode>1</errorcode>';
    echo '<errormessage>' . $bmtparser->getElement('error') . '</errormessage>';
}


echo '</ordernotification>';
echo '</response>';