<?php

	$nota = "Not\u0103 7.2 \/ Imdb 5.3" ;
	$nota2 = "Notă 7.2 \/ Imdb 5.3" ;

	$nota = mb_convert_encoding ( $nota , 'UTF-16' );
	//$nota = iconv('UTF-8', 'UTF-16', $nota);
	echo $nota;
?>