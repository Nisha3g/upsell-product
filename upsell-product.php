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
echo  "SELECT * from product_".$_REQUEST['access_token']." where product_id='".$_REQUEST['product_id']."' and upsell_show='0' and country='".$country."'"; 
?>
<div id="country-name" name="country-name"/>
<?php
$result = pg_query($db,"SELECT * from product_".$_REQUEST['access_token']." where product_id='".$_REQUEST['product_id']."' and upsell_show='0' and country='".$country."'");
	if(pg_num_rows($result) > 0){
		while($row= pg_fetch_array($result)){
			print_r($row);			
		}
	}
?>	
	<div id="cartrelatedproduct" style="display:none">
  <a class="fancybox-close1" href="/cart"></a>
  <div class="popup">        
    <div class="content">

 <script>

   $(document).ready(function(){ 
   var axes2 = new Array(); 
     var i=0;
   {% for item in cart.items %}
     if("{{ item.product.metafields.upsell-type.upsell-type }}") {
      axes2[i]="{{ item.product.metafields.upsell-type.upsell-type }}";

       i++;
    }
   {% endfor %}
   

    var distinct_axes2=[];

    for(var i=0;i<axes2.length;i++)
        {
        var str=axes2[i];
        if(distinct_axes2.indexOf(str)==-1)
            {
            distinct_axes2.push(str);
            }
        }
   if(distinct_axes2.length == 1){ 
     if(distinct_axes2[0] == 1)
     {
    
       $('.opt1').show();

     }
     else if(distinct_axes2[0] == 2) {
            $('.opt2').show();
     }
     else if(distinct_axes2[0] == 3) {
         $('.opt3').show();
     }
     else if(distinct_axes2[0] == 4) {
          $('.opt4').show();
     }
     else if(distinct_axes2[0] == 5) {
            $('.opt5').show();
     }
   }
   else {
       $('.opt6').show();
   }
    
    
   });
  
  </script>      
  <div id="four-product" class="product-upsell">
<div class="opt1" style="display:none"><div class="upsell-description">{{ settings.opt1title }}</div><div class="upsell-description-small" style="">
   {{ settings.opt1body }}</div></div>
  <div class="opt2" style="display:none">
  <div class="upsell-description">{{ settings.opt2title }}</div><div class="upsell-description-small" style="">
    {{ settings.opt2body }} </div></div>
  <div class="opt3" style="display:none">
  <div class="upsell-description">{{ settings.opt3title }}</div><div class="upsell-description-small" style="">
  {{ settings.opt3body }}</div></div>
  <div class="opt4" style="display:none">
  <div class="upsell-description">{{ settings.opt4title }}</div><div class="upsell-description-small" style="">
  {{ settings.opt4body }}</div></div>
  <div class="opt5" style="display:none">
  <div class="upsell-description">{{ settings.opt5title }}</div><div class="upsell-description-small" style="">
  {{ settings.opt5body }}</div></div>
  <div class="opt6" style="display:none">
  <div class="upsell-description">{{ settings.opt6title }}</div><div class="upsell-description-small" style="">
  {{ settings.opt6body }}</div></div>
  {% capture index %}{{ 'now' | date: '%S' | times: collections.[settings.relproduct].products.size | divided_by: 60 }}{% endcapture %}
   {% assign cartRecommend = '' %}
    <!--  content for mobile view -->
   {% include 'mobile-popupcontent' %}
    <!-- ends -->
    <!-- content for desktop -->
     {% for item in cart.items %}
    {% assign cartRecommend = item.product.metafields.upsell.collectionhandle  %}
   {% if cart.item_count == 1  %}
      {% assign limit1 = 4 %}
      {% elsif cart.item_count == 2 %}
      {% assign limit1 = 2 %}
      {% else %}
      {% assign limit1 = 2 %}
    {% endif %}
    <div class="upsell_popup_h">
      <p id="country-name"></p>
    <div class="product-wrapper-main">
   {% for product in collections.[cartRecommend].products limit:4 %}
       {% assign ptitle = product.id %}
      <div class="item ">
        <div class="countdiv" style="display:none"></div>
      {% if item.id != ptitle  %}
    	 <div class="product-wrapper product-{{ product.id }}">
  		 <div class="listviewcontent">
   		 <div class="product-image">
   			{{product.metafields.upsell.pid }}
 			<img src="{{ product.featured_image | product_img_url: 'medium' }}" alt="{{ product.title | escape  }}" /></div>
     		<div class="product-name">{{ product.title }}</div></div>
      	<div class="listviewcontent2">
         <div class="product-partnum">{{ product.variants.first.sku }}</div>
          <div class="product-options">
      		{% if  product.variants.size > 1 %}
                 <select id="product-select-{{ product.id }}" name="id"  onchange="getval('product-select-{{ product.id }}','{{ product.metafields.upsell-colname.upsell-colname }}','{{ item.product.metafields.upsell-qty.upsell-qty }}',this.value);">
                  {% for variant in product.variants %}
                
                   {% assign vtitle=variant.title | split:'-' %}
                   {% assign vsize=vtitle[1] | split:'/' %}
                
                    <option value="{{ variant.id }}">{{ vtitle[0]  }} - {{ variant.price | money }} - {{ vsize[1] }}</option>
                  {% endfor %}
                </select>
    		{% else %}
                {{ product.variants.first.title }}
     	 {% endif %}
    </div>
    
     <div class="product-buy">
      <form method="post" action="">
      <div class="product-price regular" style="display:none">$19.99</div>
      <div class="product-price sale" style="">{{ product.price | money }}</div>
      <div class="product-buttons" id="900162372-3542601220">
      <input name="quantity" style="display:none" type="text" value="1" maxlength="5" class="qty">
      <input id="addtocart1" name="addtocart" type="button" value="Add to Cart" class="addtocart-{{ product.id }} addtocart-{{ product.handle }} addtocart-{{ product.metafields.scarcity.producttype  }}"  onclick="savecart1('{{ product.variants.first.id }}','{{ product.id }}','{{ product.metafields.upsell-colname.upsell-colname }}','{{ item.product.metafields.upsell-qty.upsell-qty }}');">
        </div></form></div>
   		</div>
        <div class="cleardiv"></div></div>
      	{% endif %}
     </div>
  {% endfor %}
    </div>
  {% endfor %}
    </div>
      <!-- ends here -->
      </div>
      <div style="clear:both"></div>
      <div id="button1" class="popupbottom1" style="float:right"><style>#upsellclosebtn{float: none; color:#000;text-decoration:underline;margin-right:10px;}#upsellclosebtn:hover{float: none;color:#000;text-decoration:none;margin-right:10px;}</style><a id="upsellclosebtn" href="/checkout" class="upsell_no_thanks">No Thanks</a><a id="inline" href="/checkout" class="product-modal pm1 cart btn" style="color: rgb(255, 255, 255); margin-bottom: 7px; margin-right: 25px; margin-top: 7px; background-color: rgb(48, 194, 117);float:left">Checkout</a></div>
    </div>
 
    </div>
  </div>
 <script>
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

	$("#relCarousel1").owlCarousel({
     items : 4,
          responsive : {
                  // breakpoint from 0 up
                  0 : {
                          items: 1
                          
                  },
                  // breakpoint from 480 up 
                  480 : {
                            items: 2,
                  },
                  // breakpoint from 768 up
                  768 : {
                            items: 3
                  }
              },
            
        nav : true
      });
	function showRows() { 
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
		

	});
  
});
    
//      alert(numItems);   
   
$(window).on('resize', function(event){
  var windowWidth =$(window).width();
	var _items = 10;
	if(windowWidth > 767){
		_items = 2;
		$("#relCarousel1").owlCarousel({
			items: _items,
			nav: true,
		});
	} else if(windowWidth > 450 && windowWidth < 768){
		_items = 2;
		$("#relCarousel1").owlCarousel({
			items: _items,
			nav: true,
		});
	} else if(windowWidth < 450){
		_items = 1;
		$("#relCarousel1").owlCarousel({
          items: _items,
			nav: true,
		});
	} else {
		_items = 4;
		$("#relCarousel1").owlCarousel({
			items: _items,
			nav: true,
		});
	}
	
	function showRows() { 
	  $(".jsRow").fadeIn();
	}
    $("#relCarousel1").on('initialized.owl.carousel changed.owl.carousel refreshed.owl.carousel', function (event) {
		if (!event.namespace) return;
		var carousel = event.relatedTarget,
        element = event.target,
        current = carousel.current();
			//alert(carousel.maximum());
		if(carousel.maximum() <= 0) {
		  $('#relCarousel1 .owl-next').addClass('disabled');
		  $('#relCarousel1 .owl-prev').addClass('disabled');
		}
		else {
		  $('#relCarousel1 .owl-next').removeClass('disabled');
		  $('#relCarousel1 .owl-prev').removeClass('disabled');
		}


	});
});     
</script>
      <!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','//connect.facebook.net/en_US/fbevents.js');

fbq('init', '655260131229744');
fbq('track', "AddToCart");
</script>
      
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=655260131229744&ev=PageView&noscript=1"
/></noscript>
      
<!-- End Facebook Pixel Code -->
      	
	</body>
</html>
