<?php
	$jsonfile = file_get_contents("date.json");

	$json = json_decode( $jsonfile ) ;

	echo $json -> {'update'} ;
?>