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
 ?>
 document.write("<div id='cartrelatedproduct' style='display:none'><a class='fancybox-close1' href='/cart'></a><div class='popup'><div class='content'><?php echo $upsell_products; ?></div></div></div><div class="upsell_popup_h"><p id="country-name"></p><div class="product-wrapper-main">");
 
 
 <?php 
 for($i=0;$i<$count_upsell; $i++){ 
 echo $up_p_id=$upsell_product[$i];
 $products = $shopify("GET /admin/products/{$upsell_product[$i]}.json", array('published_status'=>'published'));
 ?> 
 document.write("<div class='item '><div class='countdiv' style='display:none'></div><div class='product-wrapper product-<?php echo $products['id']; ?>'><div class='listviewcontent'><div class='product-image'><img src='' alt='{{ product.title | escape  }}' /></div>     		<div class='product-name'><?php echo $products['title']; ?></div></div>      	<div class='listviewcontent2'>         <div class='product-partnum'>{{ product.variants.first.sku }}</div>  <div class='product-buy'>      <form method='post' action=''>      <div class='product-price regular' style='display:none'>$19.99</div>      <div class='product-price sale' style=''>{{ product.price | money }}</div>      <div class='product-buttons' id='900162372-3542601220'>      <input name='quantity' style='display:none' type='text' value='1' maxlength='5' class='qty'>      <input id='addtocart1' name='addtocart' type='button' value='Add to Cart' class='addtocart-<?php echo $products['id']; ?> addtocart-<?php echo $products['handle']; ?> addtocart-{{ product.metafields.scarcity.producttype  }}'  onclick='savecart1('{{ product.variants.first.id }}','<?php echo $products['id']; ?>','{{ product.metafields.upsell-colname.upsell-colname }}','{{ item.product.metafields.upsell-qty.upsell-qty }}');'>        </div></form></div>   		</div>        <div class='cleardiv'></div></div>     </div>");

  
<?php } ?>

document.write("  </div>
      </div><div id='four-product' class='product-upsell'><div class='opt1' style='display:none'><div class='upsell-description'><?php echo $products['title']; ?></div><div class='upsell-description-small' style=''>{{ settings.opt1body }}</div></div><div class='opt2' style='display:none'><div class='upsell-description'>{{ settings.opt2title }}</div><div class='upsell-description-small' style=''>{{ settings.opt2body }} </div></div> <div class='opt3' style='display:none'><div class='upsell-description'>{{ settings.opt3title }}</div><div class='upsell-description-small' style=''>{{ settings.opt3body }}</div></div><div class='opt4' style='display:none'><div class='upsell-description'>{{ settings.opt4title }}</div><div class='upsell-description-small' style=''> {{ settings.opt4body }}</div></div><div class='opt5' style='display:none'><div class='upsell-description'>{{ settings.opt5title }}</div><div class='upsell-description-small' style=''>{{ settings.opt5body }}</div></div>  <div class='opt6' style='display:none'><div class='upsell-description'>{{ settings.opt6title }}</div><div class='upsell-description-small' style=''>{{ settings.opt6body }}</div></div></div>");



