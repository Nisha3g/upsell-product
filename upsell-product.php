<?php 
$location = json_decode(file_get_contents('http://freegeoip.net/json/'.$_SERVER['HTTP_X_FORWARDED_FOR']),true);
$country = $location['country_name'];
require __DIR__.'/vendor/autoload.php';
	use phpish\shopify;
require __DIR__.'/conf.php'; 
$token = $_REQUEST['access_token'];
$product_id = $_REQUEST['product_id'];
$result = pg_query($db,"SELECT * from product_{$token} where product_id='{$product_id}' and upsell_show= '0' and country='{$country}'");
if(pg_num_rows($result) > 0){
	while($row= pg_fetch_array($result)){
		$upsell_products=$row['upsell_product'];
		$shop_id=$row['shop_id'];
		$upsell_show=$row['upsell_show'];		
	}
}
$result = pg_query($db,"SELECT * from app_shop_data where shop_id='{$shop_id}'");
if(pg_num_rows($result) > 0){
	while($row= pg_fetch_array($result)){
			$shop_url=$row['shop_url'];
	}}
	$upsell_product=explode(",", $upsell_products);
	$count_upsell=count($upsell_product);
 $shopify = shopify\client($shop_url, SHOPIFY_APP_API_KEY,$token);
 for($i=0;$i<$count_upsell; $i++){ 
 echo $up_p_id=$upsell_product[$i];
 $products = $shopify("GET /admin/products/{$upsell_product[$i]}.json", array('published_status'=>'published'));
 ?> 
 alert("upsell productssdsdfds"+<?php echo $upsell_product[$i];?>); 
 alert("upsell count"+<?php echo $products['title'];?>); 
<?php } ?>
document.write("<div id='cartrelatedproduct' style='display:none'><a class='fancybox-close1' href='/cart'></a><div class='popup'><div class='content'><?php echo $upsell_products; ?></div></div></div>");
document.write("<div id='four-product' class='product-upsell'><div class='opt1' style='display:none'><div class='upsell-description'>{{ product.title }}</div><div class='upsell-description-small' style=''>{{ settings.opt1body }}</div></div><div class='opt2' style='display:none'><div class='upsell-description'>{{ settings.opt2title }}</div><div class='upsell-description-small' style=''>{{ settings.opt2body }} </div></div> <div class='opt3' style='display:none'><div class='upsell-description'>{{ settings.opt3title }}</div><div class='upsell-description-small' style=''>{{ settings.opt3body }}</div></div><div class='opt4' style='display:none'><div class='upsell-description'>{{ settings.opt4title }}</div><div class='upsell-description-small' style=''> {{ settings.opt4body }}</div></div><div class='opt5' style='display:none'><div class='upsell-description'>{{ settings.opt5title }}</div><div class='upsell-description-small' style=''>{{ settings.opt5body }}</div></div>  <div class='opt6' style='display:none'><div class='upsell-description'>{{ settings.opt6title }}</div><div class='upsell-description-small' style=''>{{ settings.opt6body }}</div></div></div>");



