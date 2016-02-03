<h1>EDIT PRODUCT</h1>
<a href="index.php">Back</a>

<form>
<label>Product Id</label>
<input type="text" disabled value="<?php echo $_GET['id']; ?>" /><br/>
<label>Upsell Show</label>
<input type="radio" name="upsell_show" value="0"/>Yes
<input type="radio" name="upsell_show" value="1"/>No 
<br/>
<input type="hidden" name="n_pages" id="n_pages" value="1" />
<label>Country</label>
<select name="country">
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
</select><br/>
<label>Upsell Product IDs(Seprated by ",")</label>
<textarea name="upsell_product_id1" class="upsell_product_id"></textarea><br/>
<div class="addnew"></div>				
<input type="button" id="add_new_page" value="Add New Page" />	
<input type="submit" name="submit" value="Save"/>
</form>
<script>
jQuery(function() {
	jQuery("#add_new_country").click(function() {
		var eid = parseInt(jQuery('.upsell_product_id').length+1);
			jQuery("div[class^=addnew]:last").after('<label>Country</label><select name="country'+eid+'"><option value="arizona">Arizona</option><option value="atlanta">Atlanta</option><option value="baltimore">Baltimore</option><option value="buffalo">Buffalo</option><option value="carolina">Carolina</option><option value="chicago">Chicago</option><option value="cincinnati">Cincinnati</option><option value="cleveland">Cleveland</option><option value="dallas">Dallas</option><option value="denver">Denver</option><option value="detroit">Detroit</option><option value="green_bay">Green Bay</option><option value="indianapolis">Indianapolis</option><option value="jacksonville">Jacksonville</option><option value="kansas_city">Kansas City</option><option value="miami">Miami</option><option value="minnesota">Minnesota</option><option value="new_england">New England</option><option value="new_orleans">New Orleans</option><option value="new_york">New York</option><option value="oakland">Oakland</option><option value="philadelphia">Philadelphia</option><option value="pittsburgh">Pittsburgh</option><option value="san_diego">San Diego</option><option value="san_francisco">San Francisco</option><option value="seattle">Seattle</option><option value="washington">Washington</option></select><br/><label>Upsell Product IDs(Seprated by ",")</label><textarea name="upsell_product_id'+eid+'" class="upsell_product_id"></textarea><br/><div class="addnew"></div>');
			var n_page=jQuery('#n_pages').val();
		jQuery('#n_pages').val(parseInt(n_page)+parseInt(1));
	});
});
</script>
