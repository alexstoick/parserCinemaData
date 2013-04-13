<?php
	require('phpQuery/phpQuery.php');

	$doc = phpQuery::newDocumentFile('http://www.cinemagia.ro/program-cinema/bucuresti/');

	$json = array();

	foreach( $doc->find('.program_cinema_show') as $film )
	{
		$roTitle = pq($film)->find('.title_ro')->text() ;
		$enTitle =  pq($film)->find('h2:first')->text() ;
		$details = pq($film)->find('.info') ;

		$nota = pq($details)->find('div:first')->text() ;
		$gen = pq($details)->find('div:nth-child(2)')->text() ;
		$actori = pq($details)->find('div:nth-child(3)')->text() ;
		$regizor = pq($details)->find('div:nth-child(4)')->text() ;

		$nota = preg_replace('/\s\s+/', ' ', $nota);
		$gen = preg_replace('/\s\s+/', ' ', $gen);
		$actori = preg_replace('/\s\s+/', ' ', $actori);
		$regizor = preg_replace('/\s\s+/', ' ', $regizor);


		$cinematografe = pq($film)->find('.mb5');
		foreach ( $cinematografe as $cinematograf )
		{
			$cinemaName = pq($cinematograf)->find('.theatre-link')->text() ;

			$program = pq($cinematograf)->find('div:last') -> text ( );
			if ( $program )
			{
				//echo $cinemaName.'	(' ;
				$program = str_replace(' ', '', $program);
				$program = str_replace('\t', '', $program);
				$program = str_replace(',', '', $program);
				$program = str_replace('(ro)', '', $program);
				$program = str_replace('dublat', '', $program);
				$program = str_replace('3D' , '' , $program ) ;
				$program = preg_replace('/\s+/', '', $program);
				$length  = strlen($program);

				for($nrOra=0;$nrOra<$length/5-1;$nrOra++)
				{
					$ora =substr($program,$nrOra*5,5);
					$intrare = array( "titluEn" => $enTitle , "titluRo" => $roTitle , "cinema" => $cinemaName , "ora" => $ora,
									"nota" => $nota , "gen" => $gen , "actori" => $actori , "regizor" => $regizor ) ;
					array_push($json, $intrare) ;

				}
				$ora =substr($program,$nrOra*5,5);
			}
		}
	}

	$JSON =  array() ;
	$JSON['movies'] = $json ;
	$JSON['update'] = date ( "H:i:s") ;


	$myFile = "date.json";
	$stringData = json_encode($JSON) ;
	file_put_contents($myFile, $stringData) or die ('123') ;

	echo 'Successfully updated'.' '. $JSON['update'];

	$jsonfile = file_get_contents('date.json') or die ( '2nd update') ;

	$json = json_decode( $jsonfile ) ;

	echo $json -> {'update'} ;

?>