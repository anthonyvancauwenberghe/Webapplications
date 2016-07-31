<?php
$config = parse_ini_file('../config.ini');
$path = $config['path'];

require_once($path.'../libs/AutoLoader.php');