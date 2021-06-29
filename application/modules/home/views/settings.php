

<?php 

// print_r($client); 

?>

<!-- Start Dashboard -->

<section class="Dashboard">

	<div class="container">

		<div class="row">

			<div class="col-md-2">

				<?php include 'sidebar.php' ?>

			</div>

			<div class="col-md-10">

				<div class="DashboardContent">

					<div class="OpenTicket Box">

						<div class="BoxHeading">

							<h4> Settings</h4>

						</div>

						

						<form id="formChangePassword">

							<div class="ModelMgmt">

								<div class="row">

									<div class="col-md-12">

										<div class="form-group">

										    <label for="email">Old Password:</label>

										    <input type="text" class="form-control" id="oldpassword" name="oldpassword" placeholder="Old Password">

										</div>

									</div>

									<div class="col-md-12">

										<div class="form-group">

										    <label for="email">New Password:</label>

										    <input type="text" class="form-control" id="newpassword" name="newpassword" placeholder="New Password">

										</div>

									</div>

									<div class="col-md-12">

										<div class="form-group">

										    <label for="email">Confirm Password:</label>

										    <input type="text" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password">

										</div>

									</div>

								</div>			

							</div>

							

							<div class="BtnBox">

								<button type="submit" class="btn Save">Save</button>

								<button type="button" class="btn cancel">Cancel</button>

							</div>

						</form>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<!-- End Dashboard -->

<script type="text/javascript">



	$(function(){

 		$('#formChangePassword').submit(function(e){

 			e.preventDefault();

 			$('#displaymsg').removeClass(' alert alert-info');

            $('#displaymsg').removeClass(' alert alert-success');

            $('#displaymsg').removeClass(' alert alert-danger');



            var oldpassword = $('#oldpassword').val();

            var newpassword = $('#newpassword').val();

            var confirmpassword = $('#confirmpassword').val();



            if(oldpassword == ''){

            	$('#displaymsg').html('Enter Old Password');

              	$('#displaymsg').show().delay(5000).fadeOut();

              	$('#displaymsg').addClass(' alert alert-danger');

              	return false;

            }



            if(newpassword == ''){

            	$('#displaymsg').html('Enter New Password');

              	$('#displaymsg').show().delay(5000).fadeOut();

              	$('#displaymsg').addClass(' alert alert-danger');

              	return false;

            }

            if(newpassword != confirmpassword){

            	$('#displaymsg').html('New Password and Confirm Password not match.');

              	$('#displaymsg').show().delay(5000).fadeOut();

              	$('#displaymsg').addClass(' alert alert-danger');

              	return false;

            }



            $('#displaymsg').html('Please wait');

            $('#displaymsg').show().delay(5000).fadeOut();

            $('#displaymsg').addClass(' alert alert-info');

            // $('#myloader').show();

            $.ajax({

                url: '<?php echo base_url('change-settings'); ?>',

                type: "POST",

                data: new FormData(this),

                contentType: false,

                cache: false,

                processData: false,

                async: true,

                success: function (data) { 



                    $('#displaymsg').removeClass(' alert alert-info');

                    if(data == "success"){

                        $('#displaymsg').html('Password changed successfully');

                        $('#displaymsg').show().delay(5000).fadeOut();

                        $('#displaymsg').addClass(' alert alert-success');

                        location.reload();

                        return true;

                    }



                    if(data == "error"){

                      $('#displaymsg').html('Error to change password, retry');

                      $('#displaymsg').show().delay(5000).fadeOut();

                      $('#displaymsg').addClass(' alert alert-danger');

                      return false;

                    }

                    if(data == "oldpass"){

                      $('#displaymsg').html('Old Password not match');

                      $('#displaymsg').show().delay(5000).fadeOut();

                      $('#displaymsg').addClass(' alert alert-danger');

                      return false;

                    }

                    if(data == "pass"){

                      $('#displaymsg').html('New Password and Confirm Passord not match');

                      $('#displaymsg').show().delay(5000).fadeOut();

                      $('#displaymsg').addClass(' alert alert-danger');

                      return false;

                    }



                    $('#displaymsg').html(data);

                    $('#displaymsg').show().delay(5000).fadeOut();

                    $('#displaymsg').addClass(' alert alert-danger');

                }

            });

 		})

 	})





// $(document).ready(function(){

// 	$('#clientManagement').validate({

// 		rules: {

// 			companyname: {

// 				required:true,

// 			},

// 			name: {

// 				required:true,

// 			},

// 			addressline1: {

// 				required:true,

				 

// 			},

// 			postcode: {

// 				required:true,

// 				number:true,

// 			},

// 			vat_tin_no: {

// 				required:true,

// 			},

// 			email: {

// 				required:true,

// 				email:true,

// 			},

// 			phone: {

// 				required:true,

// 				number:true,

// 			},

// 			client_fee: {

// 				required:true,

// 				number:true,

// 			},

// 			surname: {

// 				required:true,

// 			},

// 			addressline2: {

// 				required:true,

// 			},

// 			city: {

// 				required:true,

// 			},

// 			country: {

// 				required:true,

// 			},

// 			telephone: {

// 				required:true,

// 			},

// 			internal_notes: {

// 				required:true,

// 			},

// 			shipping_companyname: {

// 				required:true,

// 			},

// 			shipping_name: {

// 				required:true,

// 			},

// 			shipping_addressline1: {

// 				required:true,

// 			},

// 			shipping_postcode: {

// 				required:true,

// 				number:true,

// 			},

// 			shipping_surname: {

// 				required:true, 

// 			},

// 			shipping_addressline2: {

// 				required:true, 

// 			},

// 			shipping_city: {

// 				required:true, 

// 			},

// 		},

// 		messages: {



// 			companyname:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Company Name. </span>",

// 			},

// 			name:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Name. </span>",

// 			},

// 			addressline1:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Address Line 1. </span>",

// 			},

// 			postcode:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Postcode. </span>",

// 				number:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Only Numbers. </span>",

// 			},

// 			vat_tin_no:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter VAT/TIN Number. </span>",

// 			},

// 			email:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Email. </span>",

// 				email:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Right Email Format. </span>",

// 			},

// 			phone:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Mobile Number. </span>",

// 				number:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Only Numbers. </span>",

// 			},

// 			client_fee:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Client Fee. </span>",

// 				number:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Only Numbers. </span>",

// 			},

// 			surname:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Surname. </span>",

// 			},

// 			addressline2:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Address Line 2. </span>",

// 			},

// 			city:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter City. </span>",

// 			},

// 			country:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Country. </span>",

// 			},

// 			telephone:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Telephone. </span>",

// 			},

// 			internal_notes:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Internal Notes. </span>",

// 			},

// 			shipping_companyname:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'> Please Enter Shipping Company Name. </span>",

// 			},



// 			shipping_name:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'> Please Enter Shipping Name. </span>",

// 			},



// 			shipping_addressline1:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'> Please Enter Shipping Address Line 1. </span>",

// 			},

// 			shipping_postcode:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Shipping Postcode. </span>",

// 				number:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Only Numbers. </span>",

// 			},

// 			shipping_surname:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Shipping Surname. </span>",

// 			},

// 			shipping_addressline2:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'> Please Enter Shipping Address Line 2. </span>",

// 			},



// 			shipping_city:{

// 				required:"<span style='font-family:cursive; font-size:12px; color:red;'>Please Enter Shipping City. </span>",

// 			},



// 		},

// 		submitHandler: function (form) {

// 			form.submit();

// 		}

// 	});

// });

</script>