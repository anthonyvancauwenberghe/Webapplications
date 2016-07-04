<?php

header('Content-Type: text/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>


<response status="1">
    <code><?php echo $code; ?></code>
    <message><?php echo $message; ?></message>
</response>