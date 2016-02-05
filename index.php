<?php 
	session_start();
	require __DIR__.'/vendor/autoload.php';
	use phpish\shopify;
	require __DIR__.'/conf.php';
	require __DIR__.'/style.css';
	if(!isset($_SESSION['auth_token'])){
	 $oauth_token = shopify\access_token($_GET['shop'], SHOPIFY_APP_API_KEY, SHOPIFY_APP_SHARED_SECRET, $_GET['code']);
	 $_SESSION['auth_token']=$oauth_token;
	 $_SESSION['shop_url']=$_GET['shop'];
	  //create new db class
    /*     $db = new DB(); */
	$host = "host=ec2-54-225-199-245.compute-1.amazonaws.com";
	$port = "port=5432";
	$dbname = "dbname=dbddrf8jsndbge";
	$user="sousqigydxxmjh";
	$password="KJBXNEMK8Vcyyf5FgIJK6yfygO";
	$credentials = "user=sousqigydxxmjh password=KJBXNEMK8Vcyyf5FgIJK6yfygO";
	$db = pg_connect( "$host $port $dbname $credentials"  );
		  $result = pg_query($db,"SELECT * from app_shop_data where shop_url=".$_GET['shop']); //where shop_url=".$_GET['shop']check if thetore exists
			if(pg_num_rows($result) > 0){
			 echo "dfdsd";
				  /*  UPDATE app_shop_data SET access_token =  'sfsdfdf' WHERE shop_url = 'dgdgf'*/
				 $sql = "UPDATE app_shop_data SET access_token =  '$oauth_token'  WHERE shop_url = '".$_GET['shop']."'";
					 pg_query($db,"UPDATE app_shop_data SET access_token =  '$oauth_token'  WHERE shop_url = '".$_GET['shop']."'");
			 }
		else{
			$sql = "UPDATE app_shop_data SET access_token =  '$oauth_token'  WHERE shop_url = '".$_GET['shop']."'";
			pg_query($db,"UPDATE app_shop_data SET access_token =  '$oauth_token'  WHERE shop_url = '".$_GET['shop']."'"); 
			/* echo "INSERT INTO app_shop_data (access_token,shop_url) VALUES ('".$_GET['shop']."','".$oauth_token."')"; */
			/* pg_query($db,"INSERT INTO app_shop_data (access_token,shop_url) VALUES ('".$_GET['shop']."','".$oauth_token."')");  */
			/* pg_query($db,"INSERT INTO app_shop_data SET  = $_GET['shop'],  = $oauth_token "); */	echo "asd";		
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
