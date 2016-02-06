<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="age-verification.css" type="text/css">
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript">
			function setMyCookie(){
alert('0');
				var now = new Date();
				
				var time = now.getTime();
				
				var expireTime = time + 1000*3600;
				
				now.setTime(expireTime);
				
				var tempExp = 'Wed, 31 Oct 2012 08:50:17 GMT';
				
				document.cookie = 'verify=true;expires='+now.toGMTString()+';path=/';
				
				document.getElementById("AVoverlay").style.setProperty('display', 'none', 'important');
				
			}
		</script>
	</head>
	<body class="vaping2">
		<div id="AVpattern">
			<div id="AVcontentBG"></div>
			<a href="http://age-verify.com" target="_blank"><img src="images/av_logo.jpg" id="AVlink"></a>
		</div>
		
		<div id="AVcontentBox" style="position: fixed; left: 50%; top: 100px; margin-left: -150px; height: 250px; width: 300px; z-index: 100001; text-align: center; color: rgb(255, 255, 255); font-size: 28px; font-family: Helvetica; padding-top: 20px; line-height: 30px;">
			<?php 

			$db = new Mysqli("localhost", "webnweb_shopify", "shopify!@#", "webnweb_shopify_app");

			if(isset($_REQUEST['sid'])){

				$sid = $_REQUEST['sid'];
				
				if($db->connect_errno){

					die('Connect Error: ' . $db->connect_errno);
					
				}

				$sql = "select heading, store_name, message_text, Button1_text, Button1_color, Button2_text, Button2_color from tbl_usersettings where access_token = '$sid'";
				
				$qry = mysqli_query($db, $sql);
				
				if ($qry) {
					
					$response = mysqli_fetch_assoc($qry);
					?>

					<h3><?php echo $response['heading']; ?></h3>
					<?php echo $response['message_text']; ?>
					<input type="button" id="avLink" onclick="window.location='http://<?php echo $response['store_name']; ?>';" style="background: <?php echo $response['Button1_color']; ?>; position: fixed; cursor: pointer; left: 50%; margin-left: -130px; top: 300px; height: 40px; width: 120px; color: rgb(255, 255, 255); font-size: 16px; padding: 0px; font-family: Helvetica; font-weight: lighter; border: 0px none; border-radius: 0px; outline: medium none; box-shadow: none;" value="<?php echo $response['Button1_text']; ?>"/>
					
					<input type="button" id="AVenterLink" onclick="setMyCookie();" style="background: <?php echo $response['Button2_color']; ?>; position: fixed; cursor: pointer; left: 50%; margin-left: 10px; top: 300px; height: 40px; width: 120px; color: rgb(255, 255, 255); font-size: 16px; padding: 0px; font-family: Helvetica; font-weight: lighter; border: 0px none; border-radius: 0px; outline: medium none; box-shadow: none;" value="<?php echo $response['Button2_text']; ?>" />
					<?php 
				} 
			} ?>
		</div>
	</body>
</html>
