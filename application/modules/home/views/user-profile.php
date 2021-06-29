

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

							<h4>Profile</h4>

						</div>

						<div class="ClientManagement">

							

							<button data-show="viewprofile" type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/'); ?>images/teamwork.svg" alt="Icon"> Profile</button>

							

							<button data-show="editprofile" type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/'); ?>images/contact.svg" alt="Icon">Edit Profile</button>

							 

						</div>

						<div class="profilecont">

							<div id="viewprofile" class="profileseperator">

								<div class="table-responsive">

									<table class="table">

										 <tr>

										 	<th>Name</th>

										 	<td><?php echo $profile->name ?></td>

										 	<td rowspan="3">

										 		<?php

										 		$profile_img = base_url('assets/frontend/images/2.jpg');

										 		if(!empty($profile->image)) {

										 			$profile_img = base_url('assets/upload/images/').$profile->image;

										 		}

										 		?>

										 		<center><img style="height: 120px; width: 120px;" alt="profile Image" src="<?php echo $profile_img ?>"></center>

										 			

										 	</td>

										 </tr>

										 <tr>

										 	<th>Email</th>

										 	<td><?php echo $profile->email ?></td>

										 </tr>

										  <tr>

										 	<th>Contact No</th>

										 	<td><?php echo $profile->phone ?></td>

										 </tr>

										 <tr>

										 	<th>Address</th>

										 	<td colspan="2"><?php echo $profile->address ?></td>

										 </tr>

										 <tr>

										 	<th>City</th>

										 	<td colspan="2"><?php echo $profile->city ?></td>

										 </tr>

										 <tr>

										 	<th>State</th>

										 	<td colspan="2"><?php echo $profile->state ?></td>

										 </tr>

										 <tr>

										 	<th>Country</th>

										 	<td colspan="2"><?php echo $profile->country ?></td>

										 </tr>

										 <tr>

										 	<th>Pincode</th>

										 	<td colspan="2"><?php echo $profile->zipcode ?></td>

										 </tr>

									</table>

								</div>

							</div>

							<div id="editprofile" class="profileseperator" style="display: none;">

								<form id="formclientManagement">

									<div class="ModelMgmt">

										<div class="row">

											<div class="col-md-6">

												<div class="form-group">

												    <label for="email">Name:</label>

												    <input type="text" class="form-control" id="name" name="name" value="<?php echo $profile->name ?>">

												</div>

											</div>

											<div class="col-md-6">

												<div class="form-group">

												    <label for="email">Email:</label>

												    <input readonly type="email" class="form-control" id="email" name="email" value="<?php echo $profile->email ?>">

												</div>

											</div>

											<div class="col-md-6">

												<div class="form-group">

												    <label for="email">Phone:</label>

												    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $profile->phone ?>">

												</div>

											</div>

											<div class="col-md-6">

												<div class="form-group">

												    <label for="email">Image:</label>

												    <input type="file" class="form-control" id="image" name="image">

												</div>

											</div>

											<div class="col-md-12">

												<div class="form-group">

												    <label for="email">Address:</label>

												    <input type="text" class="form-control" id="address" name="address" value="<?php echo $profile->address ?>">

												</div>

											</div>

											<div class="col-md-6">

												<div class="form-group">

												    <label for="email">City:</label>

												    <input type="text" class="form-control" id="city" name="city" value="<?php echo $profile->city ?>">

												</div>

											</div>

											<div class="col-md-6">

												<div class="form-group">

												    <label for="email">State:</label>

												    <input type="text" class="form-control" id="state" name="state" value="<?php echo $profile->state ?>">

												</div>

											</div>

											<div class="col-md-6">

												<div class="form-group">

												    <label for="email">Country:</label>

												    <input type="text" class="form-control" id="country" name="country" value="<?php echo $profile->country ?>">

												</div>

											</div>

											<div class="col-md-6">

												<div class="form-group">

												    <label for="email">Pincode:</label>

												    <input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo $profile->zipcode ?>">

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

		</div>

	</div>

</section>

<!-- End Dashboard -->

<script type="text/javascript">

 

	$(function(){

		$('.ClientManagement button').click(function(){

			$('.profileseperator').css('display', 'none');

			var data_show = $(this).attr('data-show');

			$('#'+data_show).css('display', 'block');

		})

	})



	$(function(){

 		$('#formclientManagement').submit(function(e){

 			e.preventDefault();

 			$('#displaymsg').removeClass(' alert alert-info');

            $('#displaymsg').removeClass(' alert alert-success');

            $('#displaymsg').removeClass(' alert alert-danger');



            $('#displaymsg').html('Please wait');

            $('#displaymsg').show().delay(5000).fadeOut();

            $('#displaymsg').addClass(' alert alert-info');

            // $('#myloader').show();

            $.ajax({

                url: '<?php echo base_url('save-profile'); ?>',

                type: "POST",

                data: new FormData(this),

                contentType: false,

                cache: false,

                processData: false,

                async: true,

                success: function (data) { 



                    $('#displaymsg').removeClass(' alert alert-info');

                    if(data == "success"){

                        $('#displaymsg').html('Profile success saved');

                        $('#displaymsg').show().delay(5000).fadeOut();

                        $('#displaymsg').addClass(' alert alert-success');

                        location.reload();

                        return true;

                    }



                    if(data == "error"){

                      $('#displaymsg').html('Error to save profile, retry');

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



 

</script>