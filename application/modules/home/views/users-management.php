
<?php 
$roles = get_issue_type();
?>
<style type="text/css">
	.mypagination{
    position: fixed;
    bottom: 5%;
    right: 5%;
}

input[name="searchtext"] {
   
        width: 80%;
    height: 35px;
}
</style>
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

							<h4>User Management </h4>

						</div>

						<div class="usersManagement">
							<form>
							
								<input type="hidden" name="role" class="form-controls" id="role" value="<?php echo $role ?>">
								<input type="text" name="searchtext" class="form-controls" id="searchtext" value="<?php echo $searchtext ?>">
								<button type="submit" class="btn bg-white btn-outline-primary"><img style="height: 20px;" src="<?php echo base_url('assets/frontend/images/funnel.svg'); ?>" alt="Icon"> Search / Filter</button>
							</form>
						</div>

						<div class="Table">

							<table class="table table-striped" id="myTable">

								<thead>

									<tr>

										<th>#</th>
										<th> Role</th>
										<th> Name</th>
										<th>Redmine username</th>
										<th>Redmine Password</th>
										<th>Email</th>
										<th>Join Date</th>
										<th>Status</th> 
										<!-- <th>Edit</th>  -->
									</tr>

								</thead>

								<tbody>


				
									<?php 


									if(!empty($users)){										
										foreach ($users as $user) {
											$status = 'Deactive';
											 if($user->status == 1){
											 	$status = 'Active';
											 }

									?>

									<tr onclick="bindProfileData(this);">										 
										<td><?php echo $user->unique_code ?></td>
										<td data-attr="<?php echo $user->redmine_assignee; ?>"><?php echo $roles[$user->redmine_assignee]; ?></td>
										<td><?php echo $user->name ?></td>
										<td><?php echo $user->redmine_username ?> </td>
										<td><?php echo $user->redmine_password ?></td>
										<td><?php echo $user->email ?></td>
										<td><?php echo date('d M, Y', strtotime($user->creation_date)) ?></td>
										<td><button class="btn btn-sm btm-primary"> <?php echo $status; ?></button></td>
									</tr>
 
									<?php
										}
									}
									?>

								</tbody>
								 

							</table>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

<!-- <div class="mypagination">
  <button id="prev_btn" data-click="1" class="btn btn-danger btn-sm"> <i class="fa fa-backward"></i> &nbsp; PREV</button>
  <button id="next_btn" data-click="2" class="btn btn-danger btn-sm"> NEXT <i class="fa fa-forward"> &nbsp; </i></button>
</div>
 -->


<div id="ModelProfile" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">User Profile</h4>
      </div>
	     <form id="formProfileUpdate">
     	 <div class="modal-body">

     	 	<div class="form-group">
				    <label for="email">Redmine Roles</label>
				     <select class="form-control" id="assignee_role" name="assignee_role">
				     	<?php 
				     	foreach ($roles as $key => $value) {
				     	?>
				     	<option value="<?php echo $key ?>"><?php echo $value ?></option>
				     	<?php
				     	}
				     	?>
				     	
				     </select>
				  </div>

	       	<div class="form-group">
				    <label for="email">Name</label>
				    <input type="hidden" class="form-control" id="empcode" name="empcode">
				    <input type="text" class="form-control" id="name" name="name">
			 		</div>

				  <div class="form-group">
				    <label for="email">Redmine Username</label>
				    <input type="text" class="form-control" id="runame" name="runame">
				  </div>

				  <div class="form-group">
				    <label for="email">Redmine Password</label>
				    <input type="password" class="form-control" id="rupassword" name="rupassword">
				  </div>

				  <div class="form-group">
				    <label for="email">Email</label>
				    <input type="email" class="form-control" id="email" name="email">
				  </div>

				  <div id="msgreg"></div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary">Save</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	      </div>
     </form>
    </div>

  </div>
</div> 
</section>


<script type="text/javascript">



	$(function(){

 		$('#formProfileUpdate').submit(function(e){
 			e.preventDefault();

			$('#msgreg').removeClass(' alert alert-info');
      $('#msgreg').removeClass(' alert alert-success');

      $('#msgreg').removeClass(' alert alert-danger');

      $('#msgreg').html('Please wait');
      $('#msgreg').show().delay(5000).fadeOut();
      $('#msgreg').addClass(' alert alert-info');
      // $('#myloader').show();

      $.ajax({

          url: '<?php echo base_url('save-user-profile') ?>',
          type: "POST",
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          async: true,
          success: function (data) { 

              $('#msgreg').removeClass(' alert alert-info');
              if(data == "success"){
                  $('#msgreg').html('Profile successfuly saved');
                  $('#msgreg').show().delay(5000).fadeOut();
                  $('#msgreg').addClass(' alert alert-success');
                  location.reload();
              }

              if(data == "email"){
                $('#msgreg').html('Email id already register try with anothr email.');
                $('#msgreg').show().delay(5000).fadeOut();
                $('#msgreg').addClass(' alert alert-danger');
                return false;
              }

              if(data == "error"){
                $('#msgreg').html('Error to save profile, retry');
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

 

	function bindProfileData(thisObj) {
		$(thisObj).find('td').each(function(index){
				// alert($(this).html());
				// alert(index);

				var myvale = $(this).html().trim();

				if(index == 0)
					$('#empcode').val(myvale);

				if(index == 1)
					$('#assignee_role').val($(this).attr('data-attr'));

				if(index == 2)
					$('#name').val(myvale);

				if(index == 3)
					$('#runame').val(myvale);

				if(index == 4)
					$('#rupassword').val(myvale);

				if(index == 5)
					$('#email').val(myvale); 
		});
		$('#ModelProfile').modal('show');
	}
	
// $(document).ready(function(){
//   $("#myInput").on("keyup", function() {
//     var value = $(this).val().toLowerCase();
//     $("#myTable tr").filter(function() {
//       $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
//     });
//   });
// });



        $("#search").keyup(function () {
            var value = this.value.toLowerCase().trim();
            $("table tbody tr").each(function (index) {
                if (!index) return;
                $(this).find("td").each(function () {
                    var id = $(this).text().toLowerCase().trim();
                    var not_found = (id.indexOf(value) == -1);
                    $(this).closest('tr').toggle(!not_found);
                    return not_found;
                });
            });
        });

        $(function(){
          var records = 100;
            var ret_data = $('#txtcounttotal').val();
            if(ret_data == ""){
              ret_data = 0;
            }
            ret_data = parseInt(ret_data);

            var pageno = getUrlVars()['page'];
            if(typeof(pageno) == "undefined"){
              pageno = 0;
            }

            pageno = parseInt(pageno);
            $('#prev_btn, #next_btn').attr('disabled', false);

            if(ret_data < 100){
              $('#next_btn').attr('disabled', true);
            }
            if(pageno <= 0){
              $('#prev_btn').attr('disabled', true);
            }            
        });

        $('.mypagination button').click(function(){

            var records = 100;
            var ret_data = $('#txtcounttotal').val();
            if(ret_data == ""){
              ret_data = 0;
            }
            ret_data = parseInt(ret_data);

            var dataClick = $(this).attr('data-click');
            var searchtext = getUrlVars()['search'];
            if(typeof(searchtext) == "undefined"){
              searchtext = '';
            }

            var pageno = getUrlVars()['page'];
            if(typeof(pageno) == "undefined"){
              pageno = 0;
            }

            pageno = parseInt(pageno);
            $('#prev_btn, #next_btn').attr('disabled', false);

            if(ret_data < 100){
              $('#next_btn').attr('disabled', true);
            }
            if(pageno <= 0){
              $('#prev_btn').attr('disabled', true);
            }

           
            if(parseInt(dataClick) == 1){
              pageno = pageno - 1;
              if(pageno < 0){
                pageno = 0;                 
                return false;

              }
            }
            else if(parseInt(dataClick) == 2){
              pageno = pageno + 1;
              if(ret_data < records){
                return false;
              }
            }
            
            
            //  if(dataClick == 'p'){
            //   pageno = pageno - 1;
            //   if(pageno < 0){
            //     pageno = 0;
            //     return false;
            //   }
            // }
            // else if(dataClick == 'n'){
            //   pageno = pageno + 1;
            //   if(ret_data < records){
            //     return false;
            //   }
            // }else{
            //     pageno = parseInt(dataClick);
            // }
             
            
            var redirectUrl = '<?php echo base_url('all-users-management') ?>?search='+searchtext+"&page="+pageno;
            window.location.href = redirectUrl;
        });


    function getUrlVars() {
      var vars = {};
      var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
      function(m,key,value) {
        vars[key] = value;
      });
      return vars;
    }
</script>

<!-- End Dashboard -->





