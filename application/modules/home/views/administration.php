



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

							<h4>Administration </h4>

						</div>

					</div>

					<div class="SmallBox Administration">

						<div class="row">

							<div class="col-lg-4 col-md-2">

								<div class="Invoice Box">

									<div class="BoxHeading minmargin">

										<h6>Edit User</h6>

									</div>

									<?php 
									$roles = get_user_autho();

									// print_r($roles);
									if(!empty($roles)){
										foreach ($roles as $role) {
											if($role == ''){
												continue;
											}
									?>

									<div class="Booker minmargin">
										 <button type="button" class="btn cancel"><?php echo $role->name ?></button> 
									</div>

									<?php
										}
									}
									?> 
 
								</div>

							</div>

							

							<div class="col-lg-4 col-md-2">

								<div class="Invoice Box">

									<div class="BoxHeading">

										<h6>Edit My Infos</h6>

									</div>

									 

										<?php 
										$content = get_footer_contents();
										$t = 0;
										foreach ($content as $value) {
										?>
										<p> <?php echo $value->content_text; ?></p>
										<?php
										if(++$t == 3){ break; }
										}
										?>

									 

									<div class="BtnBox Edit" >

										<button type="button" style="margin-top: -32%;" class="btn" onclick="bindSelectInfo();">Edit</button>

									</div>

								</div>

							</div>

<!-- 							<div class="col-lg-4 col-md-2">

								<div class="Invoice Box">

									<div class="BoxHeading minmargin">

										<h6>Edit Footer and Header</h6>

									</div>

									<div class="HeaderFooter">

										<div class="upload-btn-wrapper">

											<button class="btn">Upload a file</button>

											<input type="file" id="HeaderFooter" multiple/>

										</div>

										<div class="image-preview"></div>

									</div>

									<div class="SaveButton">

										<button type="button" class="btn">Save</button>

									</div>

								</div>

							</div> -->

							<div class="col-lg-4 col-md-2">

								<form id="formLogo" name="formLogo">
									<div class="Invoice Box">

										<div class="BoxHeading minmargin">

											<h6>Edit Logo</h6>

										</div>

										<?php 
										$logo = base_url('assets/frontend/images/logo.png');
										$setting = get_settings();
										if(!empty($setting) && !empty($setting->logo)){
											$logo = base_url('assets/frontend/images/').$setting->logo;
										}
										?>
										<div class="imglogo text-center"><img src="<?php echo $logo; ?>" alt="Logo" style="max-width: 100%; height: 30px;" /></div>

										<div class="HeaderFooter">
											<div class="upload-btn-wrapper">
												<button class="btn">Upload a file</button>
												<input type="file" id="HeaderFooter" name="image" />
											</div>
											<div class="image-preview"></div>
										</div>

										<div class="SaveButton">
											<button type="submit" class="btn">Save</button>
										</div>

									</div>
								</form>

							</div>


							<div class="col-lg-4 col-md-2">

								<div class="Invoice Box">

									<div class="BoxHeading minmargin">

										<h6>Edit User</h6>

									</div>

									<?php 
									$roles = get_issue_type();
									if(!empty($roles)){
										foreach ($roles as $key => $role) {
											if($role == ''){
												continue;
											}
									?>

									<div class="Booker minmargin">
										<a href="<?php echo base_url('user-management?role=').$key ?>"> <button type="button" class="btn cancel"><?php echo $role ?></button></a>
									</div>

									<?php
										}
									}
									?> 
 
								</div>

							</div>


						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>



<div id="modelSelectInfo" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formContents">
      	   <div class="modal-header">
	        <h4 class="modal-title">Edit My Info</h4>
	      </div>
	      <div class="modal-body">
	         <div class="form-group">
			    <label for="email">Name:</label>
			    <input type="name" class="form-control" id="selectname" name="selectname">
			  </div>
			  <div class="form-group">
			    <label for="pwd">Address 1:</label> 
			    <input type="text" class="form-control" id="address1" name="address1">
			  </div>
			  <div class="form-group">
			    <label for="pwd">Address 2:</label>
			    <input type="text" class="form-control" id="address2" name="address2">
			  </div>
			  <div class="form-group">
			    <label for="pwd">Address 3:</label>
			    <input type="text" class="form-control" id="address3" name="address3">
			  </div>
			  <div class="form-group">
			    <label for="pwd">Address 4:</label>
			    <input type="text" class="form-control" id="address4" name="address4">
			  </div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary"  >Save</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	      </div>
      </form>
    </div>

  </div>
</div>

<!-- End Dashboard -->



<script type="text/javascript">

	let file_input = document.querySelector('#HeaderFooter');

	let image_preview = document.querySelector('.image-preview');



	const handle_file_preview = (e) => {

		let files = e.target.files;

		let length = files.length;



		for(let i = 0; i < length; i++) {

			let image = document.createElement('img');

      // use the DOMstring for source

      image.src = window.URL.createObjectURL(files[i]);

      image_preview.appendChild(image);

  }

}



file_input.addEventListener('change', handle_file_preview);

// ===========



	$(function(){

		$('#formLogo').submit(function(e){
			e.preventDefault();
			$('#displaymsg').removeClass(' alert alert-info');
			$('#displaymsg').removeClass(' alert alert-success');
			$('#displaymsg').removeClass(' alert alert-danger');

			$('#displaymsg').html('Please wait');
			$('#displaymsg').show().delay(5000).fadeOut();
			$('#displaymsg').addClass(' alert alert-info');
            // $('#myloader').show();
            $.ajax({
            	url: '<?php echo base_url('save-logo'); ?>',
            	type: "POST",
            	data: new FormData(this),
            	contentType: false,
            	cache: false,
            	processData: false,
            	async: true,

            	success: function (data) { 

            		$('#displaymsg').removeClass(' alert alert-info');
            		if(data == "success"){
            			$('#displaymsg').html('Saved successfully');
            			$('#displaymsg').show().delay(5000).fadeOut();
            			$('#displaymsg').addClass(' alert alert-success');
            			location.reload();

            			return true;
            		}
            		if(data == "error"){

            			$('#displaymsg').html('Error to save logo, retry');
            			$('#displaymsg').show().delay(5000).fadeOut();
            			$('#displaymsg').addClass(' alert alert-danger');
            			return false;
            		}

            		$('#displaymsg').html(data);
            		$('#displaymsg').show().delay(5000).fadeOut();
            		$('#displaymsg').addClass(' alert alert-danger');
            	}
            });
        });




		$('#formContents').submit(function(e){
			e.preventDefault();
			$('#displaymsg').removeClass(' alert alert-info');
			$('#displaymsg').removeClass(' alert alert-success');
			$('#displaymsg').removeClass(' alert alert-danger');

			$('#displaymsg').html('Please wait');
			$('#displaymsg').show().delay(5000).fadeOut();
			$('#displaymsg').addClass(' alert alert-info');
            // $('#myloader').show();
            $.ajax({
            	url: '<?php echo base_url('save-footer-contents'); ?>',
            	type: "POST",
            	data: new FormData(this),
            	contentType: false,
            	cache: false,
            	processData: false,
            	async: true,

            	success: function (data) { 

            		$('#displaymsg').removeClass(' alert alert-info');
            		if(data == "success"){
            			$('#displaymsg').html('Saved successfully');
            			$('#displaymsg').show().delay(5000).fadeOut();
            			$('#displaymsg').addClass(' alert alert-success');
            			location.reload();

            			return true;
            		}
            		if(data == "error"){

            			$('#displaymsg').html('Error to save data, retry');
            			$('#displaymsg').show().delay(5000).fadeOut();
            			$('#displaymsg').addClass(' alert alert-danger');
            			return false;
            		}

            		$('#displaymsg').html(data);
            		$('#displaymsg').show().delay(5000).fadeOut();
            		$('#displaymsg').addClass(' alert alert-danger');
            	}
            });
        });

 
	});


	 function bindSelectInfo(){
     	$.ajax({
        	url: '<?php echo base_url('get-footer-contents'); ?>',
        	type: "POST",
        	data: {
        	},

        	success: function (data) { 

        		var req = JSON.parse(data);

        		$('#displaymsg').removeClass(' alert alert-info');
        		if(req['error'] == "success"){
        			$('#modelSelectInfo').modal('show');
        			// selectname address1
        			var fdata = req['data'];
        			$('#selectname').val(fdata[0].content_text);
        			$('#address1').val(fdata[1].content_text);
        			$('#address2').val(fdata[2].content_text);
        			$('#address3').val(fdata[3].content_text);
        			$('#address4').val(fdata[4].content_text);
        		}
        		  
        		$('#displaymsg').html(req['message']);
        		$('#displaymsg').show().delay(5000).fadeOut();
        		$('#displaymsg').addClass(' alert alert-danger');
        	}
        });
    }


</script>

<!-- Start Footer -->





