<?php

	if ( !isset ( $_GET['lat']) || !isset($_GET['lng']) )
	{
		echo 'Incorrect parameters' ;
		exit () ;
	}

	////44.419560, 26.1266510
	$lat = $_GET['lat'] ;
	$lng = $_GET['lng'] ;

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
			$url = "http://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat."%2C".$lng."&destinations=".$lat_cinema."%2C".$lng_cinema."&sensor=false" ;

			array_push ( $cinemas , array ( "lat" => $lat_cinema , "lng" => $lng_cinema , "name" => $cinema["name"]) ) ;

			// $jsonFile = @file_get_contents( $url ) ;
			// $decodedJson = json_decode( $jsonFile , true ) ;

			// if ( !isset ($decodedJson ['rows'][0]['elements'][0]['distance']['text'] ) )
			// 	$redo = true ;
			// else
			// 	$km = $decodedJson ['rows'][0]['elements'][0]['distance']['text'] ;
			// if ( ! isset( $decodedJson ['rows'][0]['elements'][0]['duration']['value'] ) )
			// 	$redo = true ;
			// else
			// 	$min = $decodedJson ['rows'][0]['elements'][0]['duration']['value'] ;

			// if ( ! $redo )
			// {
			// 	array_push ( $cinemas , array("name"=>$cinema['name'] , "km" => $km , "min" => $min , "lat_cinema" => $lat_cinema , "lng_cinema" => $lng_cinema ) ) ;
			// }

		}
	}

	foreach ( $cinemas as $cinema )
	{
		echo "'lat' =>".$cinema["lat"].", 'lng' => ".$cinema["lng"].", 'name' =>'".$cinema["name"]."' ,<br>";
	}

	$JSON = array ( ) ;
	$JSON ['cinema'] = $cinemas ;

	echo json_encode( $JSON ) ;
?>