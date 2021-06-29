

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

								 

								<div class="Invoicex Box" style="border-radius: 5px;">



									<div class="OpenTicket">

										<div class="BoxHeading">

											<h4>Register</h4>

											<p>You have already an account, <a href="<?php echo base_url('login') ?>"> Login here</a></p>

										</div>

										<form id="formRegister"  name="formRegister" method="POST">

										  <div class="form-group">

										    <label class="sr-onlya" for="email">Name:</label>

										    <input type="text" class="form-control" id="name" name="name">

										  </div>

										  <div class="form-group">

										    <label class="sr-onlya" for="email">Redmine Role:</label>


										    <select class="form-control" name="assignee" id="assignee">
										    <option selected disabled>Select Role</option>
										    <?php 
										    	$assignee_users = get_issue_type();
										    	foreach ($assignee_users as $key => $value) {
										    ?>
										    		<option value="<?php echo $key ?>"><?php echo $value ?></option>
										    <?php
										    	}
										    ?>
										    	
										    </select>

										  </div>											  



										  <div class="form-group">

										    <label class="sr-onlya" for="email">Redmine Username:</label>

										    <input type="text" class="form-control" id="redmineusername" name="redmineusername">

										  </div>

										  <div class="form-group">

										    <label class="sr-onlya" for="email">Redmine Password:</label>

										    <input type="text" class="form-control" id="redminepassword" name="redminepassword">

										  </div>



										  <div class="form-group">

										    <label class="sr-onlya" for="email">Email:</label>

										    <input type="email" class="form-control" id="email" name="email">

										  </div>



										  <div class="form-group">

										    <label class="sr-onlya" for="pwd">Password:</label>

										    <input type="password" class="form-control" id="password" name="password">

										  </div>



										   <div id="msgreg"></div>

										  <center><button type="submit" class="btn btn-info">REGISTER</button></center>

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

 		$('#formRegister').submit(function(e){

 			e.preventDefault();

 			$('#msgreg').removeClass(' alert alert-info');

            $('#msgreg').removeClass(' alert alert-success');

            $('#msgreg').removeClass(' alert alert-danger');



            $('#msgreg').html('Please wait');

            $('#msgreg').show().delay(5000).fadeOut();

            $('#msgreg').addClass(' alert alert-info');

            // $('#myloader').show();

            $.ajax({

                url: '<?php echo base_url('user-register'); ?>',

                type: "POST",

                data: new FormData(this),

                contentType: false,

                cache: false,

                processData: false,

                async: true,

                success: function (data) { 



                    $('#msgreg').removeClass(' alert alert-info');

                    if(data == "success"){

                        $('#msgreg').html('Register Success');

                        $('#msgreg').show().delay(5000).fadeOut();

                        $('#msgreg').addClass(' alert alert-success');

                        window.location.href = "<?php echo base_url('login'); ?>";

                        return true;

                    }

                    if(data == "email"){

                      $('#msgreg').html('Email id already register try with anothr email.');

                      $('#msgreg').show().delay(5000).fadeOut();

                      $('#msgreg').addClass(' alert alert-danger');

                      return false;

                    }

                    if(data == "error"){

                      $('#msgreg').html('Error to create profile, retry');

                      $('#msgreg').show().delay(5000).fadeOut();

                      $('#msgreg').addClass(' alert alert-danger');

                      return false;

                    }



                    $('#msgreg').html(data);

                    $('#msgreg').show().delay(5000).fadeOut();

                    $('#msgreg').addClass(' alert alert-danger');

                }

            });

 		})

 	})

</script>

</body>

</html> 



