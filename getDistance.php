<?php

	if ( !isset ( $_GET['lat']) || !isset($_GET['lng']) )
	{
		echo 'Incorrect parameters' ;
		exit () ;
	}


	//44.419560, 26.1266510
	$lat = 44.419560 ;
	$lng = 26.1266510 ;

	//http://maps.googleapis.com/maps/api/directions/json?origin=44.455245734355664%2C26.052256126969016&destination=44.419560%2C26.1266510&sensor=false

	$jsonFile = file_get_contents('places.json') ;

	$json = json_decode( $jsonFile , true ) ;

	$cinemas = array() ;

	foreach ( $json['cinemas'] as $cinema )
	{
		$lat_cinema = $cinema['lat'] ;
		$lng_cinema = $cinema['lng'] ;

		$redo = true ;
		while ( $redo )
		{
			$redo = false ;
			$url = "http://maps.googleapis.com/maps/api/directions/json?origin=".$lat."%2C".$lng."&destination=".$lat_cinema."%2C".$lng_cinema."&sensor=false" ;

			$jsonFile = file_get_contents( $url ) ;
			$decodedJson = json_decode( $jsonFile , true ) ;

			if ( !isset ($decodedJson ['routes'][0]['legs'][0]['distance']['text'] ) )
				$redo = true ;
			else
				$km = $decodedJson ['routes'][0]['legs'][0]['distance']['text'] ;
			if ( ! isset( $decodedJson ['routes'][0]['legs'][0]['duration']['value'] ) )
				$redo = true ;
			else
				$min = $decodedJson ['routes'][0]['legs'][0]['duration']['value'] ;

			if ( ! $redo )
			{
				array_push ( $cinemas , array("name"=>$cinema['name'] , "km" => $km , "min" => $min ) ) ;
			}
		}

	}

	var_dump ( $cinemas ) ;
?>