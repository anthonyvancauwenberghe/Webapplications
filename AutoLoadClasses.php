<?php
$config = parse_ini_file('../includes/config.ini');
$path = $config['path'];

require_once($path.'libs/AutoLoader.php');