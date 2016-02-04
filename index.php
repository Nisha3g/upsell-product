<?php 
	session_start();
	require __DIR__.'/vendor/autoload.php';
	use phpish\shopify;
	require __DIR__.'/conf.php';
	require __DIR__.'/style.css';
	require __DIR__.'class/db.php';
	if(!isset($_SESSION['auth_token'])){
	 $oauth_token = shopify\access_token($_GET['shop'], SHOPIFY_APP_API_KEY, SHOPIFY_APP_SHARED_SECRET, $_GET['code']);
	 $_SESSION['auth_token']=$oauth_token;
	 $_SESSION['shop_url']=$_GET['shop'];
	  //create new db class
        $db = new DB();
		  $select_store = pg_query($db,"SELECT * from app_shop_data where shop_url=".$_GET['shop']); //check if the store exists
  		 if($select_store->pg_num_rows > 0){
					   $sql = "UPDATE app_shop_data SET access_token = " .  $oauth_token  . " WHERE shop_url = ?";
						$params = array($_GET['shop']);
						$db->queryPreparedStatement($sql, $params);
			 }
		else{
		 
			 $sql = "INSERT INTO app_shop_data (shop_url, access_token)VALUES (?,?)";

			$params = array($_GET['shop'], $oauth_token );

			$result = $db->queryPreparedStatement($sql, $params);
		}
	}
	 $shopify = shopify\client($_SESSION['shop_url'], SHOPIFY_APP_API_KEY,$_SESSION['auth_token']);
   	try
	{
		//echo "<script>alert(1)</script>";
		# Making an API request can throw an exception
		$products = $shopify('GET /admin/products.json', array('published_status'=>'published'));
		?>
		<div class="maintable">
		<h1>PRODUCTS</h1>
		<div class="pitem pcount" style="border-top:1px solid;"><b>S.No.</b></div>
			<div class="pid pitem" style="border-top:1px solid;"><b>Product ID</b></div>
			<div class="ptitle pitem" style="border-top:1px solid;"><b>Product Name</b></div>
			<div class="pedit pitem" style="border-top:1px solid;"><b>Action</b></div>
			<div style="clear:both" style="border-top:1px solid;"></div>
		<?php 
		$count=1;
		foreach($products as $product){?>
			<div class="pitem pcount"><?php echo $count; ?></div>
			<div class="pid pitem"><?php echo $product['id']; ?></div>
			<div class="ptitle pitem"><?php echo $product['title']; ?></div>
			<div class="pedit pitem"><a href="edit_product.php?id=<?php echo $product['id']; ?>">EDIT</a></div>
			<div style="clear:both"></div>
		<?php	}	?>
			
		</div>
		<?php
	}
	catch (shopify\ApiException $e)
	{
		# HTTP status code was >= 400 or response contained the key 'errors'
		echo $e;
		print_r($e->getRequest());
		print_r($e->getResponse());
	}
	catch (shopify\CurlException $e)
	{
		# cURL error
		echo $e;
		print_r($e->getRequest());
		print_r($e->getResponse());
	}
