<?php
require_once '../includes/Callbacks/BmtMicro.php';
require_once '../includes/Callbacks/BMTXMLParser.php';

$bmtparser = new BMTXMLParser ();
$bmtmicro = new BmtMicro();

echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<response>';
echo '<ordernotification>';

if ($bmtparser->parse($HTTP_RAW_POST_DATA)) {
    $bmtmicro->insertQuery($bmtparser);
}

else {
    echo '<errorcode>1</errorcode>';
    echo '<errormessage>' . $bmtparser->getElement('error') . '</errormessage>';
}


echo '</ordernotification>';
echo '</response>';