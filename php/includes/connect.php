<?php

error_reporting(E_ALL ^ E_NOTICE);

try {
	$db = new PDO('sqlite:' . getenv('OPENSHIFT_DATA_DIR') . 'leads.sqlite');
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

?>