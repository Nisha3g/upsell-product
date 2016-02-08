<script>
document.write('<?php $location = json_decode(file_get_contents('http://freegeoip.net/json/'.$_SERVER['HTTP_X_FORWARDED_FOR']),true);$country=$location['country_name'];require __DIR__.'/conf.php'; require __DIR__.'/style.css';?><div id="country-name" name="country-name"/><?php $result = pg_query($db,"SELECT * from product_".$_REQUEST['access_token']." where product_id='".$_REQUEST['product_id']."' and upsell_show='0' and country='".$country."'");if(pg_num_rows($result) > 0){while($row= pg_fetch_array($result)){print_r($row);}}?>');
</script>
