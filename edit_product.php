<?php session_start();
require __DIR__.'/vendor/autoload.php';
	use phpish\shopify;
require __DIR__.'/conf.php'; 
require __DIR__.'/style.css'; 
if(isset($_REQUEST['submit'])){
	$oauth_token=$_SESSION['auth_token'];
	pg_query($db,"Delete from product_".$oauth_token." where product_id='".$_REQUEST['id']."'");
	for($loop=1; $loop<=$_REQUEST['n_country']; $loop++)
	{
		$country  ='country'.$loop;
		$upsell_product_id  ='upsell_product_id'.$loop;
		/* echo "INSERT INTO product_".$oauth_token." (shop_id,product_id,upsell_show,country,upsell_product,body_html,vendor,product_type,handle,template_suffix,published_scope,tags,variants,options,images,image,created_at,updated_at,published_at,title_upsell,body_upsell,max_qty) VALUES ('".$_SESSION['shop_id']."','".$_REQUEST['id']."','".$_REQUEST['upsell_show']."','".$_REQUEST[$country]."','".$_REQUEST[$upsell_product_id]."','".$_REQUEST['body_html']."','".$_REQUEST['vendor']."','".$_REQUEST['product_type']."','".$_REQUEST['handle']."','".$_REQUEST['template_suffix']."','".$_REQUEST['published_scope']."','".$_REQUEST['tags']."','".$_REQUEST['variants']."','".$_REQUEST['options']."','".$_REQUEST['images']."','".$_REQUEST['image']."','".$_REQUEST['created_at']."','".$_REQUEST['updated_at']."','".$_REQUEST['published_at']."','".$_REQUEST['title_upsell']."','".$_REQUEST['body_upsell']."','".$_REQUEST['max_qty']."')"; */
		pg_query($db,"INSERT INTO product_".$oauth_token." (shop_id,product_id,upsell_show,country,upsell_product,body_html,vendor,product_type,handle,template_suffix,published_scope,tags,variants,options,images,image,created_at,updated_at,published_at,title_upsell,body_upsell,max_qty) VALUES ('".$_SESSION['shop_id']."','".$_REQUEST['id']."','".$_REQUEST['upsell_show']."','".$_REQUEST[$country]."','".$_REQUEST[$upsell_product_id]."','".$_REQUEST['body_html']."','".$_REQUEST['vendor']."','".$_REQUEST['product_type']."','".$_REQUEST['handle']."','".$_REQUEST['template_suffix']."','".$_REQUEST['published_scope']."','".$_REQUEST['tags']."','".$_REQUEST['variants']."','".$_REQUEST['options']."','".$_REQUEST['images']."','".$_REQUEST['image']."','".$_REQUEST['created_at']."','".$_REQUEST['updated_at']."','".$_REQUEST['published_at']."','".$_REQUEST['title_upsell']."','".$_REQUEST['body_upsell']."','".$_REQUEST['max_qty']."')");
	}
}
$result = pg_query($db,"SELECT * from app_shop_data where shop_id='".$_SESSION['shop_id']."'");
if(pg_num_rows($result) > 0){while($row= pg_fetch_array($result)){
			$shop_url=$row['shop_url'];
	}}
 ?>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<?php $product_id=$_GET['id'];
 $shopify = shopify\client($_SESSION['shop_url'], SHOPIFY_APP_API_KEY,$_SESSION['auth_token']);
$products = $shopify("GET /admin/products/{$product_id}.json", array('published_status'=>'published'));

?>
<h1>EDIT PRODUCT</h1>
<a href="index.php" class="black_link">Back</a>
<?php /* <a href="upsell-product.php?access_token=<?php echo $_SESSION['auth_token']; ?>&product_id=<?php echo $_REQUEST['id'];?>">Preview</a> */?>
<form method="POST">
<label>Product Id</label>
<input type="text" disabled value="<?php echo $_GET['id']; ?>" name="id"/><br/>
<label>Product name</label>
<input type="text" disabled value='<?php echo $products['title']; ?>' name="title"/><br/>
<input type="hidden" name="body_html"  id="body_html" value='<?php if(is_array($products['body_html'])){ echo json_encode($products['body_html']);} else{ echo $products['body_html']; } ?>' />
<input type="hidden" name="vendor"  id="vendor"  value='<?php if(is_array($products['vendor'])){ echo json_encode($products['vendor']);} else{ echo $products['vendor']; } ?>'/>
<input type="hidden" name="product_type"  id="product_type"  value='<?php if(is_array($products['product_type'])){ echo json_encode($products['product_type']);} else{ echo $products['product_type']; } ?>'/>
<input type="hidden" name="created_at"  id="created_at" value='<?php if(is_array($products['created_at'])){ echo json_encode($products['created_at']);} else{ echo $products['created_at']; } ?>' />
<input type="hidden" name="updated_at"  id="updated_at" value='<?php if(is_array($products['updated_at'])){ echo json_encode($products['updated_at']);} else{ echo $products['updated_at']; } ?>' />
<input type="hidden" name="published_at"  id="published_at"  value='<?php if(is_array($products['published_at'])){ echo json_encode($products['published_at']);} else{ echo $products['published_at']; } ?>'/>
<input type="hidden" name="handle"  id="handle" value='<?php if(is_array($products['handle'])){ echo json_encode($products['handle']);} else{ echo $products['handle']; } ?>' />
<input type="hidden" name="template_suffix"  id="template_suffix" value='<?php if(is_array($products['template_suffix'])){ echo json_encode($products['template_suffix']);} else{ echo $products['template_suffix']; } ?>' />
<input type="hidden" name="published_scope"  id="published_scope" value='<?php if(is_array($products['published_scope'])){ echo json_encode($products['published_scope']);} else{ echo $products['published_scope']; } ?>' />
<input type="hidden" name="tags"  id="tags" value='<?php if(is_array($products['tags'])){ echo json_encode($products['tags']);} else{ echo $products['tags']; } ?>' />
<input type="hidden" name="variants"  id="variants" value='<?php if(is_array($products['variants'])){ echo json_encode($products['variants']);} else{ echo $products['variants']; } ?>' />
<input type="hidden" name="options"  id="options" value='<?php if(is_array($products['options'])){ echo json_encode($products['options']);} else{ echo $products['options']; } ?>' />
<input type="hidden" name="images"  id="images" value='<?php if(is_array($products['images'])){ echo json_encode($products['images']);} else{ echo $products['images']; } ?>' />
<input type="hidden" name="image"  id="image" value='<?php if(is_array($products['image'])){ echo json_encode($products['image']);} else{ echo $products['image']; } ?>' />
<label>Upsell Show</label>
<input type="radio" name="upsell_show" value="0" checked />Yes
<input type="radio" name="upsell_show" value="1"/>No 
<br/><?php
$result = pg_query($db,"SELECT * from product_".$_SESSION['auth_token']." where product_id='".$_REQUEST['id']."'");
		$title_upsell='';$body_upsell='';
		if(pg_num_rows($result) > 0){
			$n_country=	pg_num_rows($result);
			$i=1;
			while($row= pg_fetch_array($result)){
					$title_upsell=$row['title_upsell'];
					$body_upsell=$row['body_upsell'];
					$max_qty=$row['max_qty'];
				}
		}?>
<label>Title for Upsell</label>
<input type="text" value='<?php echo $title_upsell; ?>' name="title_upsell"/><br/>
<label>body for Upsell</label>
<textarea name="body_upsell"><?php echo $body_upsell; ?></textarea><br/>
<label>Maximum Quantity</label>
<input type="text" value='<?php echo $max_qty; ?>' name="max_qty"/><br/>

<?php
$result = pg_query($db,"SELECT * from product_".$_SESSION['auth_token']." where product_id='".$_REQUEST['id']."'");
		if(pg_num_rows($result) > 0){
			$n_country=	pg_num_rows($result);
			$i=1;
			while($row= pg_fetch_array($result)){
				
			?>
				<label>Country</label>
				<select name="country<?php echo $i; ?>">
					<option value="Arizona" <?php if($row['country']=="Arizona"){echo "Selected"; } ?>>Arizona</option>
					<option value="Atlanta" <?php if($row['country']=="Atlanta"){echo "Selected"; } ?>>Atlanta</option>
					<option value="Baltimore" <?php if($row['country']=="Baltimore"){echo "Selected"; } ?>>Baltimore</option>
					<option value="Buffalo" <?php if($row['country']=="Buffalo"){echo "Selected"; } ?>>Buffalo</option>
					<option value="Carolina" <?php if($row['country']=="Carolina"){echo "Selected"; } ?>>Carolina</option>
					<option value="Chicago" <?php if($row['country']=="Chicago"){echo "Selected"; } ?>>Chicago</option>
					<option value="Cincinnati" <?php if($row['country']=="Cincinnati"){echo "Selected"; } ?>>Cincinnati</option>
					<option value="Cleveland" <?php if($row['country']=="Cleveland"){echo "Selected"; } ?>>Cleveland</option>
					<option value="Dallas" <?php if($row['country']=="Dallas"){echo "Selected"; } ?>>Dallas</option>
					<option value="Denver" <?php if($row['country']=="Denver"){echo "Selected"; } ?>>Denver</option>
					<option value="Detroit" <?php if($row['country']=="Detroit"){echo "Selected"; } ?>>Detroit</option>
					<option value="Green Bay" <?php if($row['country']=="Green Bay"){echo "Selected"; } ?>>Green Bay</option>
					<option value="Indianapolis" <?php if($row['country']=="Indianapolis"){echo "Selected"; } ?>>Indianapolis</option>
					<option value="Jacksonville" <?php if($row['country']=="Jacksonville"){echo "Selected"; } ?>>Jacksonville</option>
					<option value="Kansas City" <?php if($row['country']=="Kansas City"){echo "Selected"; } ?>>Kansas City</option>
					<option value="Miami" <?php if($row['country']=="Miami"){echo "Selected"; } ?>>Miami</option>
					<option value="Minnesota" <?php if($row['country']=="Minnesota"){echo "Selected"; } ?>>Minnesota</option>
					<option value="New England" <?php if($row['country']=="New England"){echo "Selected"; } ?>>New England</option>
					<option value="New Orleans" <?php if($row['country']=="New Orleans"){echo "Selected"; } ?>>New Orleans</option>
					<option value="New York" <?php if($row['country']=="New York"){echo "Selected"; } ?>>New York</option>
					<option value="Oakland" <?php if($row['country']=="Oakland"){echo "Selected"; } ?>>Oakland</option>
					<option value="Philadelphia" <?php if($row['country']=="Philadelphia"){echo "Selected"; } ?>>Philadelphia</option>
					<option value="Pittsburgh" <?php if($row['country']=="Pittsburgh"){echo "Selected"; } ?>>Pittsburgh</option>
					<option value="San Diego" <?php if($row['country']=="San Diego"){echo "Selected"; } ?>>San Diego</option>
					<option value="San Francisco" <?php if($row['country']=="San Francisco"){echo "Selected"; } ?>>San Francisco</option>
					<option value="Seattle" <?php if($row['country']=="Seattle"){echo "Selected"; } ?>>Seattle</option>
					<option value="Washington" <?php if($row['country']=="Washington"){echo "Selected"; } ?>>Washington</option>
					<option value="Mohali" <?php if($row['country']=="Mohali"){echo "Selected"; } ?>>Mohali(India)</option>
				</select><br/>
				<label>Upsell Product IDs(Seprated by ",")</label>
				<textarea name="upsell_product_id<?php echo $i; ?>" class="upsell_product_id"><?php echo $row['upsell_product']; ?></textarea>
				<br/>
				<div class="addnew"></div>	
			<?php $i++; }	

		}
		else{ $n_country=1;	?>				
				<label>Country</label>
				<select name="country1">
					<option value="Arizona">Arizona</option>
					<option value="Atlanta">Atlanta</option>
					<option value="Baltimore">Baltimore</option>
					<option value="Buffalo">Buffalo</option>
					<option value="Carolina">Carolina</option>
					<option value="Chicago">Chicago</option>
					<option value="Cincinnati">Cincinnati</option>
					<option value="Cleveland">Cleveland</option>
					<option value="Dallas">Dallas</option>
					<option value="Denver">Denver</option>
					<option value="Detroit">Detroit</option>
					<option value="Green Bay">Green Bay</option>
					<option value="Indianapolis">Indianapolis</option>
					<option value="Jacksonville">Jacksonville</option>
					<option value="Kansas City">Kansas City</option>
					<option value="Miami">Miami</option>
					<option value="Minnesota">Minnesota</option>
					<option value="New England">New England</option>
					<option value="New Orleans">New Orleans</option>
					<option value="New York">New York</option>
					<option value="Oakland">Oakland</option>
					<option value="Philadelphia">Philadelphia</option>
					<option value="Pittsburgh">Pittsburgh</option>
					<option value="San Diego">San Diego</option>
					<option value="San Francisco">San Francisco</option>
					<option value="Seattle">Seattle</option>
					<option value="Washington">Washington</option>
					<option value="Mohali">Mohali(India)</option>
				</select>
				<br/>
				<label>Upsell Product IDs(Seprated by ",")</label>
				<textarea name="upsell_product_id1" class="upsell_product_id"></textarea><br/>
						<div class="addnew"></div>	
		<?php }?>
<input type="hidden" name="n_country" id="n_country" value="<?php echo $n_country; ?>" />		
<input type="button" id="add_new_country" value="Add New Country" />	
<input type="submit" name="submit" value="Save"/>
</form>
<script>

	$("#add_new_country").click(function() {
		 var eid = parseInt($('.upsell_product_id').length+1);
			$("div[class^=addnew]:last").after('<label>Country</label><select name="country'+eid+'"><option value="Arizona">Arizona</option><option value="Atlanta">Atlanta</option><option value="Baltimore">Baltimore</option><option value="Buffalo">Buffalo</option><option value="Carolina">Carolina</option><option value="Chicago">Chicago</option><option value="Cincinnati">Cincinnati</option><option value="Cleveland">Cleveland</option>					<option value="Dallas">Dallas</option><option value="Denver">Denver</option>					<option value="Detroit">Detroit</option><option value="Green Bay">Green Bay</option><option value="Indianapolis">Indianapolis</option><option value="Jacksonville">Jacksonville</option><option value="Kansas City">Kansas City</option><option value="Miami">Miami</option>					<option value="Minnesota">Minnesota</option><option value="New England">New England</option><option value="New Orleans">New Orleans</option><option value="New York">New York</option>					<option value="Oakland">Oakland</option><option value="Philadelphia">Philadelphia</option><option value="Pittsburgh">Pittsburgh</option><option value="San Diego">San Diego</option>					<option value="San Francisco">San Francisco</option><option value="Seattle">Seattle</option><option value="Washington">Washington</option><option value="Mohali">Mohali(India)</option></select><br/><label>Upsell Product IDs(Seprated by ",")</label><textarea name="upsell_product_id'+eid+'" class="upsell_product_id"></textarea><br/><div class="addnew"></div>');
			var n_country=$('#n_country').val();
		$('#n_country').val(parseInt(n_country)+parseInt(1)); 
	});
</script>
