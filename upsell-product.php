<?php 

$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
$api_key="6c0706c14e72e6376bf58f1b5434cb7b4dc934492207b1b690c1078b6d32c19c";
 $details =json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=$api_key&ip=$ip&format=json"));
$country = $details->cityName;
require __DIR__.'/vendor/autoload.php';
	use phpish\shopify;
require __DIR__.'/conf.php';
require __DIR__.'/fancybox/fancybox.js';
require __DIR__.'/fancybox/owl.carousel.min.js';
$token = $_REQUEST['access_token'];
$product_id = $_REQUEST['product_id'];
$result = pg_query($db,"SELECT * from product_{$token} where product_id='{$product_id}' and upsell_show= '0' and country='{$country}'");
if(pg_num_rows($result) > 0){
	while($row= pg_fetch_array($result)){
		$upsell_products=$row['upsell_product'];
		$shop_id=$row['shop_id'];
		$upsell_show=$row['upsell_show'];		
		$title_upsell=$row['title_upsell'];		
		$body_upsell=$row['body_upsell'];		
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
 document.write("<div id='cartrelatedproduct' style='display:none'><a class='fancybox-close1' href='/cart'></a><div class='popup'><div class='content'><div id='four-product' class='product-upsell'><div class='opt1' ><div class='upsell-description'><?php echo $title_upsell; ?></div><div class='upsell-description-small' style=''><?php echo $body_upsell; ?></div></div><div class='hidd mobilecontent' style='display:none'><div  id='relCarousel1' class='container jsCollection row-store-collection relCarousel_1'><?php for($i=0;$i<$count_upsell; $i++){$up_p_id=$upsell_product[$i]; $products = $shopify("GET /admin/products/{$upsell_product[$i]}.json", array('published_status'=>'published'));  $upsell_product_id=$products['id'];?> <div class='col-md-3 col-sm-3 col-xs-12'> <div class='product_image'>   <center>   		<img style='width:auto;' src='<?php echo $products['image']['src']; ?>' /></center></div>     <div class='product-name1' style='text-align:center'><?php echo $products['title']; ?></div>	<div class='product-partnum'><?php echo $products['variants'][0]['sku']; ?></div> 	<div class='product-options' style='text-align:center;'>     <select id='product-select-<?php echo $products['id']; ?>' name='id' onchange='getval(<?php echo $upsell_product_id; ?>,this.value);'> <?php foreach($products['variants'] as $variant) {     $vtitle=explode('/',$variant['title']);                   $vsize=$vtitle[0];                ?>                    <option value='<?php echo $variant['id']; ?>'><?php echo $vtitle[0].'- $'.$variant['price'].'USD -'.$vtitle[1];?></option>               <?php   } ?>                 </select>   	</div>     <div class='product-buy' style='text-align:center;'><form method='post' action=''><div class='product-price sale' style=''><?php echo $products['variants'][0]['price'] ?></div><div class='product-buttons' id='900162372-3542601220'><input name='quantity' style='display:none' type='text' value='1' maxlength='5' class='qty'><input id='addtocart1' name='addtocart' type='button' value='Add to Cart' class='addtocart-<?php echo $products['id']; ?> addtocart-<?php echo $products['handle']; ?> addtocart-<?php echo $products['product_type']; ?>'  onclick='savecart1(<?php echo $products['variants'][0]['id'];?>,<?php echo $products['id']; ?>);'>  </div></form></div></div><?php  } ?>   </div> </div> <div class='upsell_popup_h'><p id='country-name'></p><div class='product-wrapper-main'>");
 
 
 <?php 
 for($i=0;$i<$count_upsell; $i++){ 
$up_p_id=$upsell_product[$i];
 $products = $shopify("GET /admin/products/{$upsell_product[$i]}.json", array('published_status'=>'published'));
  $upsell_product_id=$products['id'];?> 

 document.write("<div class='item '><div class='countdiv' style='display:none'></div><div class='product-wrapper product-<?php echo $products['id']; ?>'><div class='listviewcontent'><div class='product-image'><img src='<?php echo $products['image']['src']; ?>' alt='<?php echo $products['title']; ?>' /></div>     		<div class='product-name'><?php echo $products['title']; ?></div></div>      	<div class='listviewcontent2'>         <div class='product-partnum' style='display:none;'><?php echo $products['variants'][0]['sku']; ?></div>  <div class='product-options'>    		<?php if(count($products['variants']) > 1 ) {?>               <select id='product-select-<?php echo $products['id']; ?>' name='id' onchange='getval(<?php echo $upsell_product_id; ?>,this.value);'> <?php foreach($products['variants'] as $variant) {     $vtitle=explode('/',$variant['title']);                   $vsize=$vtitle[0];                ?>                    <option value='<?php echo $variant['id']; ?>'><?php echo $vtitle[0].'- $'.$variant['price'].'USD -'.$vtitle[1];?></option>               <?php   } ?>                 </select>    		<?php } ?>  </div> <div class='product-buy'>      <form method='post' action=''><div class='product-price sale' style=''>$<?php echo $products['variants'][0]['price'] ?>USD</div>      <div class='product-buttons' id='900162372-3542601220'>      <input name='quantity' style='display:none' type='text' value='1' maxlength='5' class='qty'>      <input id='addtocart1' name='addtocart' type='button' value='Add to Cart' class='addtocart-<?php echo $products['id']; ?> addtocart-<?php echo $products['handle']; ?> addtocart-<?php echo $products['product_type']; ?>'  onclick='savecart1(<?php echo $products['variants'][0]['id'];?>,<?php echo $products['id']; ?>);'>        </div></form></div>   		</div>        <div class='cleardiv'></div></div>      </div> ");

  
<?php } ?>
 document.write("</div></div></div><div style='clear:both'></div><div id='button1' class='popupbottom1' style='float:right'><a id='upsellclosebtn' href='/checkout' class='upsell_no_thanks'>No Thanks</a><a id='inline' href='/checkout' class='product-modal pm1 cart btn' style='color: rgb(255, 255, 255); margin-bottom: 7px; margin-right: 25px; margin-top: 7px; background-color: rgb(48, 194, 117);float:left'>Checkout</a></div></div></div></div>");
  $(document).ready(function() {
	$( "#AddToCart" ).click(function() {
			$.fancybox.open([
			{
			  href : '#cartrelatedproduct',
			  //title : '1st title'
			}
			], {
			  padding : 0   
			});
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
   function savecart1(variantid,pid1) {
      var cartpid = new Array(); 
      var cartcat = new Array(); 
      var handingoption = new Array();
      var cartcatnew = new Array(); 
        var j=0;
      var k=0;
        $.ajax({
            type: 'POST',
            url: '/cart/add.js', 
          	dataType: 'text',
         data: { quantity: 1, 
                id: variantid },
       	success: function(response){
              var response = $.parseJSON(response);
               var msg='added to your cart';
                  
           $('.addtocart-'+pid1).val('Added');
           window.location.href = "/cart?pop=true";
        }
        });
      } 
	  function getval(sel,pidd) {
          $(".addtocart-"+sel).attr("onclick","savecart1 ('"+pidd+"','"+sel+"')");
      
     }
	 $(document).ready(function(){ 
	var countdiv =parseInt($('.countdiv').length);
	//alert(countdiv);
	if(countdiv == 1)
	{
		$('.product-wrapper-main').addClass('one');
	}
	else if(countdiv == 2)
	{
		$('.product-wrapper-main').addClass('two');
	}
	else if(countdiv == 3)
	{
		$('.product-wrapper-main').addClass('three');
	}
	else if(countdiv == 4)
	{
		$('.product-wrapper-main').addClass('four');
	}
	else if(countdiv > 4)
	{
		$('.product-wrapper-main').addClass('listview');
		
	}
	var windowWidth =$(window).width();
	if(windowWidth > 767){
		$('.mobilecontent').hide();
		$('.upsell_popup_h').show();
	} else {
		  $('.mobilecontent').show();
		  $('.upsell_popup_h').hide();
		}
	
/* 	function showRows() { 
	  $('.jsRow').fadeIn();
	}
	  $('#relCarousel1').on('initialized.owl.carousel changed.owl.carousel refreshed.owl.carousel', function (event) {
		if (!event.namespace) return;
		var carousel = event.relatedTarget,
        element = event.target,
        current = carousel.current();
		
		if(carousel.maximum() <= 0) {
		  $('#relCarousel1 .owl-next').addClass('disabled');
		  $('#relCarousel1 .owl-prev').addClass('disabled');
		}
		else {
		  $('#relCarousel1 .owl-next').removeClass('disabled');
		  $('#relCarousel1 .owl-prev').removeClass('disabled');
		}		
	}); */
	 });
	$(window).on('load', function(){
		iniOwl('#relCarousel1');
	});
	function iniOwl(container){
		$(container).owlCarousel({
			items : 4,
			responsive :{
				0 : {
					items: 1,
				},
				480 : {
					items: 2,
				},
				768 : {
					items: 3,
				}
			},

			nav : true
		});
	}
	$(window).on('resize', function(event){
		var windowWidth =$(window).width();
		/* var _items = 10; */
		if(windowWidth > 767){
			$('.mobilecontent').hide();
			$('.upsell_popup_h').show();
			/* _items = 2;
			$("#relCarousel1").owlCarousel({
				items: _items,
				nav: true,
			}); */
		} else if(windowWidth > 450 && windowWidth < 768){
			$('.mobilecontent').show();
			$('.upsell_popup_h').hide();
			/* _items = 2;
			$("#relCarousel1").owlCarousel({
				items: _items,
				nav: true,
			}); */
		} else if(windowWidth < 450){
			$('.mobilecontent').show();
			$('.upsell_popup_h').hide();
			/* _items = 1;
			$("#relCarousel1").owlCarousel({
				items: _items,
				nav: true,
			}); */
		} else {
			$('.mobilecontent').show();
			$('.upsell_popup_h').hide();
			/* _items = 4;
			$("#relCarousel1").owlCarousel({
				items: _items,
				nav: true,
			}); */
		}
		iniOwl('#relCarousel1');
		/* function showRows() { 
		  $(".jsRow").fadeIn();
		}
		$("#relCarousel1").on('initialized.owl.carousel changed.owl.carousel refreshed.owl.carousel', function (event) {
			if (!event.namespace) return;
			var carousel = event.relatedTarget,
			element = event.target,
			current = carousel.current();
			if(carousel.maximum() <= 0) {
			  $('#relCarousel1 .owl-next').addClass('disabled');
			  $('#relCarousel1 .owl-prev').addClass('disabled');
			}
			else {
			  $('#relCarousel1 .owl-next').removeClass('disabled');
			  $('#relCarousel1 .owl-prev').removeClass('disabled');
			}	
		}); */
	}); 
document.write("<style>#upsellclosebtn{float: none; color:#000;text-decoration:underline;margin-right:10px;}#upsellclosebtn:hover{float: none;color:#000;text-decoration:none;margin-right:10px;}.upsell_popup_h .listview .item { width: 250px;    display: inline-block;    float: left;}.item .listviewcontent .product-image img { width: 100%;}.product-wrapper-main .item .product-wrapper {    border: 1px solid #dddddd;    float: left;    height: auto;    margin: 10px 6px 0;    padding: 10px 0;    text-align: center;    width: 100%;}#addtocart1 {   background: #000;    padding: 7px;    border: none;    border-radius: 5px;    color: #fff;}.upsell-description-small {    color: #666666;    height: 32px;    overflow: hidden;    margin-left: 9px;}.upsell-description {color: #1B78AA;    font-size: 30px;    font-weight: bold;    max-height: 40px;    overflow: hidden;    margin-left: 8px;}#four-product .product-wrapper-main .product-wrapper .product-buttons {  margin: 10px 0;}#four-product .product-wrapper-main .product-wrapper {  border: 1px solid #dddddd;  float: left; margin: 10px 6px 0;  padding: 10px 15px;  text-align: center;  width: 23%;}#four-product .product-wrapper-main.two .product-wrapper {  text-align: center;  width: 48%;}#four-product .product-wrapper-main.one .product-wrapper {  text-align: center;  width: 100%;}#four-product .product-wrapper-main.three .product-wrapper {  width: 31%;  text-align: center;}#four-product .product-wrapper-main.four .product-wrapper {  text-align: center;  width: 23%;}#four-product .product-wrapper-main.listview .product-wrapper .listviewcontent {  float: left;  width: 40%;}#four-product .product-wrapper-main.listview .product-wrapper .listviewcontent2 {  border-left: 1px dashed #ccc;  float: left;  width: 60%;}#four-product .product-wrapper-main.listview .product-buy {  border: 0 none;}#four-product .product-wrapper-main.listview .product-wrapper {  border: 1px solid #dddddd;  float: left;  height: auto;  margin: 10px 6px 0;  padding: 10px 0;  text-align: center;  width: 100%;}#four-product .product-wrapper-main .product-wrapper .listviewcontent2 .product-options select {  height: 35px;  width: 95%;  text-overflow:'';}.upsell_popup_h { display: inline-block;    width: 100%;}.upsell_popup_h .listview .item { width: 250px;    display: inline-block;    float: left;}.upsell_popup_h .listview .item .listviewcontent{ width: 100% !important;}.upsell_popup_h .listview .item .listviewcontent2 { width: 100% !important;}.upsell_popup_h .listview .item .product-partnum { display: none;}.upsell_popup_h .listview .item .product-image{     height: 100% !important;    width: 95% !important;}.upsell_popup_h .listview .item .product-image img{ width: 100% !important; max-width: 100% !important; max-height: 100% !important;}.upsell_popup_h .upsell_popup_h{ display: none;}.product-wrapper-main.one{    max-width: 500px;    padding: 10px;}.product-wrapper-main.two{    max-width: 800px;    padding: 10px;}.col-md-3{width:25%}.col-sm-3{width:25%}.col-xs-12{width:100%}</style>");

