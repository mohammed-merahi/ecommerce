<?php

    $db   = 'cirtagestcom_ecommerce';
    $user = 'root';
    $pw   = '--vLnaUxDuSyGaT75K--';

	//$link = mysql_connect('localhost', 'root', '') or die('Could not connect: ' . mysql_error());
	$link = mysql_connect('localhost', $user, $pw) or die('Could not connect: ' . mysql_error());
	mysql_select_db($db) or die('Could not select database');
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8',
	character_set_database = 'utf8', character_set_server = 'utf8'", $link);

?>
