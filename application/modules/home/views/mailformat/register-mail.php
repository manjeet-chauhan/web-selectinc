<!DOCTYPE html>
<html>
<head>
	<title>Paanduv | Register</title>
	<style type="text/css">
		@media(max-width: 480px){
			.mediawith100{
				width: 100% !important;
			}
		}
	</style>
</head>
 
<body>
	<div style="border: 1px solid #000; width: 50%;" class="mediawith100">
		<div style="background-color: #ffb5b5; background-color: #fff; padding: 5px; border-bottom: 2px solid #000;" >
			<center><img src="<?php echo base_url('assets/frontend/images/logo-colorful.png') ?>" style="height: 60px;"></center>
		</div>
		<div style="background-color: #039BC9; padding: 20px; color: #fff;">
			<div style="font-size: 28px; text-align: center;">Welcome <?php echo $usrname ?> !</div>
			<div style="text-align: center; margin: 25px 0;  font-size: 22px; color: #040404;"> Registration Successfully completed </div>
			<div style="text-align: center; font-size: 16px; line-height: 25px; letter-spacing: 1px;">Hi <?php echo $usrname ?>, your registered email id : 
				<b style="color: #000; font-size: 15px;"><a href="mailto:<?php echo $usremail ?>" style="color: #000;"><?php echo $usremail ?></a></b>
			</div>
			<div style="border-bottom: 1px solid #fff; padding-bottom: 25px;"></div>
			<br>
			<div style="text-align: center; font-size: 16px; line-height: 25px; letter-spacing: 1px;"> Your email id is not verified. Click below link to verify your email id.</div>
			<br>
			<div style="text-align: center; font-size: 16px; line-height: 25px; letter-spacing: 1px;"><a href="<?php echo $usrverifylink ?>" style=" color: #a20606;" > Click here to verify your email id</a> </div>
			
		</div>
		<div style="background-color: #000; color: #fff; padding: 5px 0; text-align: center; font-size: 16px; line-height: 25px; letter-spacing: 1px;" >
			Thank you for connecting with us
		</div>
	</div>
</body>
</html>