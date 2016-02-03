<?php

	define('SHOPIFY_APP_API_KEY', '7662e5daf152854818a5066e4d5e61d6');
	define('SHOPIFY_APP_SHARED_SECRET', '77e2b001dfdb274bada219d669a0528d');
	$host = "host=ec2-54-225-199-245.compute-1.amazonaws.com";
	$port = "port=5432";
	$dbname = "dbname=dbddrf8jsndbge";
	$credentials = "user=sousqigydxxmjh password=KJBXNEMK8Vcyyf5FgIJK6yfygO";
	$db = pg_connect( "$host $port $dbname $credentials"  );
	if(!$db){
	    echo "Error : Unable to open database\n";
	}
?>
