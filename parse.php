<?php

$array = ['Movieplex Cinema Plaza','Grand Cinema Digiplex','Hollywood Multiplex','The Light Cinema','Cinema City Cotroceni','Cinema City Cotroceni VIP','Cinema City Sun Plaza','Grand VIP Studios','CinemaPRO','Glendale Studio','Patria','Romtelecom IMAXÂ®','Studio','Caffe Cinema 3D Patria','Scala','Gloria','Europa','Movie Vip Caffe','Corso'] ;

$jsonfile = file_get_contents('movie_theatre.json') ;

$json = json_decode( $jsonfile , true ) ;

$results = $json ['results'] ;

$cinemas = array ( ) ;

foreach ( $results as $cinema )
{
	//var_dump ( $cinema ) ; exit ( ) ;
	$cinemaName = $cinema['name'] ;
	$location = $cinema['geometry']['location'] ;
	array_push($cinemas, array( "name" => $cinemaName , "location" => $location) ) ;
}

$i = 0 ;

foreach ( $array as $cinema )
{

	foreach ( $cinemas as $place )
		if ( $cinema === $place['name'] )
		{
			var_dump ( $place ) ;
		}

}

?>