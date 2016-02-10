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
 document.write("<div id='cartrelatedproduct' style='display:none'><a class='fancybox-close1' href='/cart'></a><div class='popup'><div class='content'><?php echo $upsell_products; ?><div class='upsell_popup_h'><p id='country-name'></p><div class='product-wrapper-main'>");
 
 
 <?php 
 for($i=0;$i<$count_upsell; $i++){ 
 echo $up_p_id=$upsell_product[$i];
 $products = $shopify("GET /admin/products/{$upsell_product[$i]}.json", array('published_status'=>'published'));
$products['image_url']=json_decode($products['image']);
 ?> 
 alert(<?php echo $products['image']['src']; ?>);
 alert(<?php echo $products['image_url']['src']; ?>);
 document.write("<div class='item '><div class='countdiv' style='display:none'></div><div class='product-wrapper product-<?php echo $products['id']; ?>'><div class='listviewcontent'><div class='product-image'><img src='<?php echo $products['image_url']['src']; ?>' alt='{{ product.title | escape  }}' /></div>     		<div class='product-name'><?php echo $products['title']; ?></div></div>      	<div class='listviewcontent2'>         <div class='product-partnum'>{{ product.variants.first.sku }}</div>  <div class='product-buy'>      <form method='post' action=''>      <div class='product-price regular' style='display:none'>$19.99</div>      <div class='product-price sale' style=''>{{ product.price | money }}</div>      <div class='product-buttons' id='900162372-3542601220'>      <input name='quantity' style='display:none' type='text' value='1' maxlength='5' class='qty'>      <input id='addtocart1' name='addtocart' type='button' value='Add to Cart' class='addtocart-<?php echo $products['id']; ?> addtocart-<?php echo $products['handle']; ?> addtocart-{{ product.metafields.scarcity.producttype  }}'  onclick='savecart1();'>        </div></form></div>   		</div>        <div class='cleardiv'></div></div>      </div> ");

  
<?php } ?>
 document.write("</div></div><div style='clear:both'></div><div id='button1' class='popupbottom1' style='float:right'><style>#upsellclosebtn{float: none; color:#000;text-decoration:underline;margin-right:10px;}#upsellclosebtn:hover{float: none;color:#000;text-decoration:none;margin-right:10px;}</style><a id='upsellclosebtn' href='/checkout' class='upsell_no_thanks'>No Thanks</a><a id='inline' href='/checkout' class='product-modal pm1 cart btn' style='color: rgb(255, 255, 255); margin-bottom: 7px; margin-right: 25px; margin-top: 7px; background-color: rgb(48, 194, 117);float:left'>Checkout</a></div></div></div></div>");
  $(document).ready(function() {
        $.fancybox.open([
        {
          href : '#cartrelatedproduct',
          //title : '1st title'
        }
        ], {
          padding : 0   
        });
  });
   $('.product-modal').fancybox({
    helpers: {
      overlay: {
        locked: false
      }
    },
  'afterClose':function () {
      window.location.href='/checkout';
    }
  });



