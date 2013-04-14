<?php
	$jsonfile = file_get_contents("www/date.json");

	$json = json_decode( $jsonfile ) ;

	echo $json -> {'update'} ;
?>