<html>
	<head>
		<title></title>
		<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	</head>
	<body class="vaping2">
<?php/* <script>
$.ajax( { 
  url: 'https://freegeoip.net/json/', 
  type: 'POST', 
  dataType: 'jsonp',
  success: function(location) {
	  alert(location.country_name);
	   jQuery('#country-name').html(location.country_name);
	   
  }
} );
</script> */?>
 <?php
/* echo $user_ip = $_SERVER['REMOTE_ADDR'];
$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
echo $country = $geo["geoplugin_countryName"];
echo $city = $geo["geoplugin_city"]; */
$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
echo $details->city; 
session_start();
print_r($_SESSION);
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
