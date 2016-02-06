<?php session_start();
print_r($_SESSION);
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
	/* 	echo "SELECT * from product_".$oauth_token." where product_id='".$_REQUEST['id']."' and country='".$_REQUEST[$country]."'";
		echo "INSERT INTO product_".$oauth_token." (shop_id,product_id,upsell_show,country,upsell_product) VALUES ('".$_SESSION['shop_id']."','".$_REQUEST['id']."','".$_REQUEST['upsell_show']."','".$_REQUEST[$country]."','".$_REQUEST[
			$upsell_product_id]."')"; */
	/*  $result = pg_query($db,"SELECT * from product_".$oauth_token." where product_id='".$_REQUEST['id']."' and country='".$_REQUEST[$country]."'");		
		if(pg_num_rows($result) > 0){
			
			pg_query($db,"UPDATE product_".$oauth_token." SET upsell_product =  '".$_REQUEST[$upsell_product_id]."' WHERE product_id='".$_REQUEST['id']."' and  country = '".$_REQUEST[$country]."'");
			
		}
		else{
			
			 pg_query($db,"INSERT INTO product_".$oauth_token." (shop_id,product_id,upsell_show,country,upsell_product) VALUES ('".$_SESSION['shop_id']."','".$_REQUEST['id']."','".$_REQUEST['upsell_show']."','".$_REQUEST[$country]."','".$_REQUEST[
			$upsell_product_id]."')");
		}  */
	}
}
 ?>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

<h1>EDIT PRODUCT</h1>
<a href="index.php">Back</a>

<form method="POST">
<label>Product Id</label>
<input type="text" disabled value="<?php echo $_GET['id']; ?>" name="id"/><br/>
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
				if($row['upsell_product']!=""){
			?>
				<label>Country</label>
				<select name="country<?php echo $i; ?>">
					<option value="arizona" <?php if($row['country']=="arizona"){echo "Selected"; } ?>>Arizona</option>
					<option value="atlanta" <?php if($row['country']=="atlanta"){echo "Selected"; } ?>>Atlanta</option>
					<option value="baltimore" <?php if($row['country']=="baltimore"){echo "Selected"; } ?>>Baltimore</option>
					<option value="buffalo" <?php if($row['country']=="buffalo"){echo "Selected"; } ?>>Buffalo</option>
					<option value="carolina" <?php if($row['country']=="carolina"){echo "Selected"; } ?>>Carolina</option>
					<option value="chicago" <?php if($row['country']=="chicago"){echo "Selected"; } ?>>Chicago</option>
					<option value="cincinnati" <?php if($row['country']=="cincinnati"){echo "Selected"; } ?>>Cincinnati</option>
					<option value="cleveland" <?php if($row['country']=="cleveland"){echo "Selected"; } ?>>Cleveland</option>
					<option value="dallas" <?php if($row['country']=="dallas"){echo "Selected"; } ?>>Dallas</option>
					<option value="denver" <?php if($row['country']=="denver"){echo "Selected"; } ?>>Denver</option>
					<option value="detroit" <?php if($row['country']=="detroit"){echo "Selected"; } ?>>Detroit</option>
					<option value="green_bay" <?php if($row['country']=="green_bay"){echo "Selected"; } ?>>Green Bay</option>
					<option value="indianapolis" <?php if($row['country']=="indianapolis"){echo "Selected"; } ?>>Indianapolis</option>
					<option value="jacksonville" <?php if($row['country']=="jacksonville"){echo "Selected"; } ?>>Jacksonville</option>
					<option value="kansas_city" <?php if($row['country']=="kansas_city"){echo "Selected"; } ?>>Kansas City</option>
					<option value="miami" <?php if($row['country']=="miami"){echo "Selected"; } ?>>Miami</option>
					<option value="minnesota" <?php if($row['country']=="minnesota"){echo "Selected"; } ?>>Minnesota</option>
					<option value="new_england" <?php if($row['country']=="new_england"){echo "Selected"; } ?>>New England</option>
					<option value="new_orleans" <?php if($row['country']=="new_orleans"){echo "Selected"; } ?>>New Orleans</option>
					<option value="new_york" <?php if($row['country']=="new_york"){echo "Selected"; } ?>>New York</option>
					<option value="oakland" <?php if($row['country']=="oakland"){echo "Selected"; } ?>>Oakland</option>
					<option value="philadelphia" <?php if($row['country']=="philadelphia"){echo "Selected"; } ?>>Philadelphia</option>
					<option value="pittsburgh" <?php if($row['country']=="pittsburgh"){echo "Selected"; } ?>>Pittsburgh</option>
					<option value="san_diego" <?php if($row['country']=="san_diego"){echo "Selected"; } ?>>San Diego</option>
					<option value="san_francisco" <?php if($row['country']=="san_francisco"){echo "Selected"; } ?>>San Francisco</option>
					<option value="seattle" <?php if($row['country']=="seattle"){echo "Selected"; } ?>>Seattle</option>
					<option value="washington" <?php if($row['country']=="washington"){echo "Selected"; } ?>>Washington</option>
				</select><br/>
				<label>Upsell Product IDs(Seprated by ",")</label>
				<textarea name="upsell_product_id<?php echo $i; ?>" class="upsell_product_id"><?php echo $row['upsell_product']; ?></textarea>
				<br/>
				<div class="addnew"></div>	
				<?php}   $i++;}	

		}
		else{ $n_country=1;	?>				
				<label>Country</label>
				<select name="country1">
					<option value="arizona">Arizona</option>
					<option value="atlanta">Atlanta</option>
					<option value="baltimore">Baltimore</option>
					<option value="buffalo">Buffalo</option>
					<option value="carolina">Carolina</option>
					<option value="chicago">Chicago</option>
					<option value="cincinnati">Cincinnati</option>
					<option value="cleveland">Cleveland</option>
					<option value="dallas">Dallas</option>
					<option value="denver">Denver</option>
					<option value="detroit">Detroit</option>
					<option value="green_bay">Green Bay</option>
					<option value="indianapolis">Indianapolis</option>
					<option value="jacksonville">Jacksonville</option>
					<option value="kansas_city">Kansas City</option>
					<option value="miami">Miami</option>
					<option value="minnesota">Minnesota</option>
					<option value="new_england">New England</option>
					<option value="new_orleans">New Orleans</option>
					<option value="new_york">New York</option>
					<option value="oakland">Oakland</option>
					<option value="philadelphia">Philadelphia</option>
					<option value="pittsburgh">Pittsburgh</option>
					<option value="san_diego">San Diego</option>
					<option value="san_francisco">San Francisco</option>
					<option value="seattle">Seattle</option>
					<option value="washington">Washington</option>
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

	$("#add_new_country").click(function() {alert(1);
		 var eid = parseInt($('.upsell_product_id').length+1);
			$("div[class^=addnew]:last").after('<label>Country</label><select name="country'+eid+'"><option value="arizona">Arizona</option><option value="atlanta">Atlanta</option><option value="baltimore">Baltimore</option><option value="buffalo">Buffalo</option><option value="carolina">Carolina</option><option value="chicago">Chicago</option><option value="cincinnati">Cincinnati</option><option value="cleveland">Cleveland</option><option value="dallas">Dallas</option><option value="denver">Denver</option><option value="detroit">Detroit</option><option value="green_bay">Green Bay</option><option value="indianapolis">Indianapolis</option><option value="jacksonville">Jacksonville</option><option value="kansas_city">Kansas City</option><option value="miami">Miami</option><option value="minnesota">Minnesota</option><option value="new_england">New England</option><option value="new_orleans">New Orleans</option><option value="new_york">New York</option><option value="oakland">Oakland</option><option value="philadelphia">Philadelphia</option><option value="pittsburgh">Pittsburgh</option><option value="san_diego">San Diego</option><option value="san_francisco">San Francisco</option><option value="seattle">Seattle</option><option value="washington">Washington</option></select><br/><label>Upsell Product IDs(Seprated by ",")</label><textarea name="upsell_product_id'+eid+'" class="upsell_product_id"></textarea><br/><div class="addnew"></div>');
			var n_country=$('#n_country').val();
		$('#n_country').val(parseInt(n_country)+parseInt(1)); 
	});
</script>
