<?php

error_reporting(E_ALL ^ E_NOTICE);

$db_host = '';
$db_user = '';
$db_pass = '';
$db_name = '';


$db = new PDO('sqlite:' . getenv('OPENSHIFT_DATA_DIR') . 'table.sqlite');

@$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);



$mysqli->set_charset("utf8");


?>