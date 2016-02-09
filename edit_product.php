<?php session_start();
/*print_r($_SESSION);*/
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
		pg_query($db,"INSERT INTO product_".$oauth_token." (shop_id,product_id,upsell_show,country,upsell_product) VALUES ('".$_SESSION['shop_id']."','".$_REQUEST['id']."','".$_REQUEST['upsell_show']."','".$_REQUEST[$country]."','".$_REQUEST[
			$upsell_product_id]."')");
	}
}
$result = pg_query($db,"SELECT * from app_shop_data where shop_id='".$_SESSION['shop_id']."'");
if(pg_num_rows($result) > 0){while($row= pg_fetch_array($result)){
			$shop_url=$row['shop_url'];
	}}
 ?>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script>
/* jQuery.ajax({
       type: 'GET',
       url: 'https://<?php echo $shop_url ?>/admin/products/<?php echo $_GET['id'] ?>.json?access_token=<?php echo$_SESSION['auth_token'] ?>', 
       success: function(response){
		   alert(response)
         	$('#image').val(response);
     	}
     }); */
</script>
<?php $product_id=$_GET['id'];
 $shopify = shopify\client($_SESSION['shop_url'], SHOPIFY_APP_API_KEY,$_SESSION['auth_token']);
$products = $shopify("GET /admin/products/{$product_id}.json", array('published_status'=>'published'));
/* print_r($shopify);*/
print_r($products); 
?>
<h1>EDIT PRODUCT</h1>
<a href="index.php">Back</a>
<a href="upsell-product.php?access_token=<?php echo $_SESSION['auth_token']; ?>&product_id=<?php echo $_REQUEST['id'];?>">Preview</a>

<form method="POST">
<label>Product Id</label>
<input type="text" disabled value="<?php echo $_GET['id']; ?>" name="id"/><br/>
<label>Product name</label>
<input type="text" disabled value="<?php echo $products['title']; ?>" name="title"/><br/>
<input type="hidden" name="body_html"  id="body_html" value="<?php echo $products['body_html']; ?>" />
<input type="hidden" name="vendor"  id="vendor"  value="<?php echo $products['vendor']; ?>"/>
<input type="hidden" name="product_type"  id="product_type"  value="<?php echo $products['product_type']; ?>"/>
<input type="hidden" name="created_at"  id="created_at" value="<?php echo $products['created_at']; ?>" />
<input type="hidden" name="updated_at"  id="updated_at" value="<?php echo $products['updated_at']; ?>" />
<input type="hidden" name="published_at"  id="published_at"  value="<?php echo $products['published_at']; ?>"/>
<input type="hidden" name="handle"  id="handle" value="<?php echo $products['handle']; ?>" />
<input type="hidden" name="template_suffix"  id="template_suffix" value="<?php echo $products['template_suffix']; ?>" />
<input type="hidden" name="published_scope"  id="published_scope" value="<?php echo $products['published_scope']; ?>" />
<input type="hidden" name="tags"  id="tags" value="<?php echo $products['tags']; ?>" />
<input type="hidden" name="variants"  id="variants" value="<?php echo $products['variants']; ?>" />
<input type="hidden" name="options"  id="options" value="<?php echo $products['options']; ?>" />
<input type="hidden" name="images"  id="images" value="<?php echo $products['images']; ?>" />
<input type="hidden" name="image"  id="image" value="<?php echo $products['image']; ?>" />
<label>Upsell Show</label>
<input type="radio" name="upsell_show" value="0" checked />Yes
<input type="radio" name="upsell_show" value="1"/>No 
<br/>
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
					<option value="India" <?php if($row['country']=="India"){echo "Selected"; } ?>>India</option>
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
					<option value="India">India</option>
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
			$("div[class^=addnew]:last").after('<label>Country</label><select name="country'+eid+'"><option value="Arizona">Arizona</option><option value="Atlanta">Atlanta</option><option value="Baltimore">Baltimore</option><option value="Buffalo">Buffalo</option><option value="Carolina">Carolina</option><option value="Chicago">Chicago</option><option value="Cincinnati">Cincinnati</option><option value="Cleveland">Cleveland</option>					<option value="Dallas">Dallas</option><option value="Denver">Denver</option>					<option value="Detroit">Detroit</option><option value="Green Bay">Green Bay</option><option value="Indianapolis">Indianapolis</option><option value="Jacksonville">Jacksonville</option><option value="Kansas City">Kansas City</option><option value="Miami">Miami</option>					<option value="Minnesota">Minnesota</option><option value="New England">New England</option><option value="New Orleans">New Orleans</option><option value="New York">New York</option>					<option value="Oakland">Oakland</option><option value="Philadelphia">Philadelphia</option><option value="Pittsburgh">Pittsburgh</option><option value="San Diego">San Diego</option>					<option value="San Francisco">San Francisco</option><option value="Seattle">Seattle</option><option value="Washington">Washington</option><option value="India">India</option></select><br/><label>Upsell Product IDs(Seprated by ",")</label><textarea name="upsell_product_id'+eid+'" class="upsell_product_id"></textarea><br/><div class="addnew"></div>');
			var n_country=$('#n_country').val();
		$('#n_country').val(parseInt(n_country)+parseInt(1)); 
	});
</script>
