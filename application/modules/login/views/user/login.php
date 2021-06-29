
<?php 


?>
<!-- Start Dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Select Inc.</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>css/style.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>css/responsive.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>plugin/bootstrap.min.css">
	<link rel="icon" href="<?php echo base_url('assets/frontend'); ?> assets/images/fav-icon.png" type="image/png" sizes="16x16"> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="<?php echo base_url('assets/frontend/'); ?>plugin/jquery.min.js"></script>
	<script src="<?php echo base_url('assets/frontend/'); ?>plugin/popper.min.js"></script>
	<script src="<?php echo base_url('assets/frontend/'); ?>plugin/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>


	<style type="text/css">
		body{
			background-image: url('<?php echo base_url('assets/backloginimg.jpg'); ?>');
			background-size: cover;
		}
	</style>
</head> 
<body>

 
<section class="Dashboard">

	<div class="container">

		<div class="row"> 
			<div class="col-md-12"> 
				<div class="DashboardContentxx">  
					<div class="SmallBox"> 
						<div class="row"> 
							<div class="col-lg-4 col-md-2">
							</div> 
							<div class="col-lg-4 col-md-4"> 
								<br>
								<br>
								<div class="Invoicex Box" style="border-radius: 5px;">

									<div class="OpenTicket">
										<div class="BoxHeading">
											<h4>Login</h4>
											<p>You havn't an account, <a href="<?php echo base_url('register') ?>"> Create Profile</a></p>
										</div>
										<form id="formLogin" name="formLogin">
											 
											  <div class="form-group">
											    <label class="sr-onlya" for="email">Email address:</label>
											    <input type="email" class="form-control" id="email" name="email">
											  </div>
											  <div class="form-group">
											    <label class="sr-onlya" for="pwd">Password:</label>
											    <input type="password" class="form-control" id="password" name="password">
											  </div>
											  <div class="checkbox">
											    <label><input type="checkbox"> Remember me</label>
											  </div>
											  <div id="msglogin"></div>
											  <center><button type="submit" class="btn btn-info">Submit</button></center>
										</form>
									</div>
								</div>
							</div>

							 
						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<!-- End Dashboard -->

 <script type="text/javascript">

 	$(function(){
 		$('#formLogin').submit(function(e){
 			e.preventDefault();
 			$('#msglogin').removeClass(' alert alert-info');
            $('#msglogin').removeClass(' alert alert-success');
            $('#msglogin').removeClass(' alert alert-danger');

            $('#msglogin').html('Please wait');
            $('#msglogin').show().delay(5000).fadeOut();
            $('#msglogin').addClass(' alert alert-info');
            // $('#myloader').show();
            $.ajax({
                url: '<?php echo base_url('user-login'); ?>',
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                async: true,
                success: function (data) { 

                    $('#msglogin').removeClass(' alert alert-info');
                    if(data == "success"){
                        $('#msglogin').html('Login success');
                        $('#msglogin').show().delay(5000).fadeOut();
                        $('#msglogin').addClass(' alert alert-success');
                        window.location.href = "<?php echo base_url(); ?>";
                        return true;
                    }
                    if(data == "error"){
                      $('#msglogin').html('Error to login, retry');
                      $('#msglogin').show().delay(5000).fadeOut();
                      $('#msglogin').addClass(' alert alert-danger');
                      return true;
                    }

                    $('#msglogin').html(data);
                    $('#msglogin').show().delay(5000).fadeOut();
                    $('#msglogin').addClass(' alert alert-danger');
                }
            });
 		})
 	})
</script>

 
</body>
</html> 

