<?php session_start(); ?>
<html>
	<head>
		<title></title>
		<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	</head>
	<body class="vaping2">
<?php 
 $location = json_decode(file_get_contents('http://freegeoip.net/json/'.$_SERVER['HTTP_X_FORWARDED_FOR']),true);
 $country=$location['country_name'];
require __DIR__.'/conf.php'; 
require __DIR__.'/style.css';
echo  "SELECT * from product_".$_REQUEST['access_token']." where product_id='".$_REQUEST['product_id']."' and upsell_show='0'"; 
?>
<div id="country-name" name="country-name"/>
<?php
$result = pg_query($db,"SELECT * from product_".$_REQUEST['access_token']." where product_id='".$_REQUEST['product_id']."' and upsell_show='0'");
	if(pg_num_rows($result) > 0){
		while($row= pg_fetch_array($result)){
			print_r($row);			
		}
	}
?>		
	</body>
</html>
