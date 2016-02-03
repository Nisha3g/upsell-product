<?php 
	session_start();
	require __DIR__.'/vendor/autoload.php';
	use phpish\shopify;
	require __DIR__.'/conf.php';
	 $oauth_token = shopify\access_token($_GET['shop'], SHOPIFY_APP_API_KEY, SHOPIFY_APP_SHARED_SECRET, $_GET['code']);
	//	    $shopify = shopify\client($_SESSION['shop'], $_SESSION['oauth_token'], SHOPIFY_APP_API_KEY, SHOPIFY_APP_SHARED_SECRET);
	 $shopify = shopify\client($_GET['shop'], SHOPIFY_APP_API_KEY,$oauth_token);
   	try
	{
		//echo "<script>alert(1)</script>";
		# Making an API request can throw an exception
		$products = $shopify('GET /admin/products.json', array('published_status'=>'published'));
		?>
		<div class="maintable">
		<h1>PRODUCTS</h1>
		<div class="pcount">S.No.</div>
			<div class="pid">Product ID</div>
			<div class="ptitle">Product Name</div>
			<div class="pedit">Action</div>
		<?php 
		$count=1;
		foreach($products as $product){?>
			<div class="pcount"><?php echo $count; ?></div>
			<div class="pid"><?php echo $product['id']; ?></div>
			<div class="ptitle"><?php echo $product['title']; ?></div>
			<div class="pedit"><a href="edit_product.php?id=<?php echo $product['id']; ?>">EDIT</a></div>
			
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
