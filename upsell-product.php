<html>
	<head>
		<title></title>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	</head>
	<body class="vaping2">
<?php session_start();
print_r($_SESSION);
require __DIR__.'/conf.php'; 
require __DIR__.'/style.css';
echo  "SELECT * from product_".$_REQUEST['access_token']." where product_id='".$_REQUEST['product_id']."' and upsell_show=0";
			$result = pg_query($db,"SELECT * from product_".$_REQUEST['access_token']." where product_id='".$_REQUEST['product_id']."' and upsell_show=0");
				if(pg_num_rows($result) > 0){
					while($row= pg_fetch_array($result)){
						print_r($row);
					}						
					
					
				}
			?>		
	</body>
</html>
