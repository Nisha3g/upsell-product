<?php 
$location = json_decode(file_get_contents('http://freegeoip.net/json/'.$_SERVER['HTTP_X_FORWARDED_FOR']),true);
$country = $location['country_name'];
require __DIR__.'/conf.php'; 
$token = $_REQUEST['access_token'];
$product_id = $_REQUEST['product_id'];
$result = pg_query($db,"SELECT * from product_{$token} where product_id='{$product_id}' and upsell_show= '0' and country='{$country}'");
if(pg_num_rows($result) > 0){
	while($row= pg_fetch_array($result)){
		$upsell_products=$row['upsell_product'];
	}
} ?>
document.write("<div id='cartrelatedproduct' style='display:none'><a class='fancybox-close1' href='/cart'></a><div class='popup'><div class='content'><?php echo $upsell_products; ?></div></div></div>");
document.write("<div id='four-product' class='product-upsell'><div class='opt1' style='display:none'><div class='upsell-description'>{{ product.title }}</div><div class='upsell-description-small' style=''>{{ settings.opt1body }}</div></div><div class='opt2' style='display:none'><div class='upsell-description'>{{ settings.opt2title }}</div><div class='upsell-description-small' style=''>{{ settings.opt2body }} </div></div> <div class='opt3' style='display:none'><div class='upsell-description'>{{ settings.opt3title }}</div><div class='upsell-description-small' style=''>{{ settings.opt3body }}</div></div><div class='opt4' style='display:none'><div class='upsell-description'>{{ settings.opt4title }}</div><div class='upsell-description-small' style=''> {{ settings.opt4body }}</div></div><div class='opt5' style='display:none'><div class='upsell-description'>{{ settings.opt5title }}</div><div class='upsell-description-small' style=''>{{ settings.opt5body }}</div></div>  <div class='opt6' style='display:none'><div class='upsell-description'>{{ settings.opt6title }}</div><div class='upsell-description-small' style=''>{{ settings.opt6body }}</div></div></div>");



