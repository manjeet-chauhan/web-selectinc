

<style type="text/css">
	.mypagination{
    position: fixed;
    bottom: 5%;
    right: 5%;
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

							<h4>Client Management </h4>

						</div>

						<div class="ClientManagement">
							<form>

							<a href="<?php echo base_url('all-client-management'); ?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/teamwork.svg'); ?>" alt="Icon"> All Clients</button></a>

							<a href="<?php echo base_url('add-client-management'); ?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/contact.svg'); ?>" alt="Icon"> Add Client</button></a>

							<button data-toggle="modal" data-target="#ModelImport" type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/import.svg'); ?>" alt="Icon"> Import Client</button>

							 
							
								<input type="text" name="search" class="form-controls" id="search" value="<?php echo $searchtext ?>">
								<button type="submit" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/funnel.svg'); ?>" alt="Icon"> Search / Filter</button>
							</form>
							 

						</div>

						<div class="Table">

							<table class="table table-striped" id="myTable">

								<thead>

									<tr>

										<th>#</th>
										<th>Company Name</th>

										<th>Full Name</th>

										<th>Address</th>

										<th>Client Fee</th>

										<!-- <th style="width: 10%;">View</th> -->

										<!-- <th style="width: 10%;">Edit Client</th> -->

									</tr>

								</thead>

								<tbody>


									<?php 
									$totalcount = 0;
			                        if(!empty($client_mgmt)){
			                          $totalcount = count($client_mgmt);
			                        }
			                        ?>
			                        <input type="hidden" name="txtcounttotal" id="txtcounttotal" value="<?php echo $totalcount; ?>">

									<?php 

									if(!empty($client_mgmt)){
										$count = 100*$page;

										foreach ($client_mgmt as $client) {

											$redirect_view = base_url('client-management-detail/').$client->unique_code;

											$redirect_edit = base_url('edit-client-management/').$client->unique_code;

									?>

									<tr onclick="window.location.href='<?php echo $redirect_edit; ?>'">
										 <th><?php echo ++$count; ?></th>
										<td><?php echo $client->company_name ?></td>

										<td><?php echo $client->name ?> </td>

										<td><?php echo $client->address_line1 ?></td>

										<td><?php echo $client->client_fee ?>%</td>

										 

										<!-- <td><a href="<?php echo $redirect_view; ?>"><button type="button" class="btn"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a></td> -->

										<!-- <td><a href="<?php echo $redirect_edit; ?>"><button type="button" class="btn"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></a></td> -->

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

<div class="mypagination">
  <button id="prev_btn" data-click="1" class="btn btn-danger btn-sm"> <i class="fa fa-backward"></i> &nbsp; PREV</button>
  <button id="next_btn" data-click="2" class="btn btn-danger btn-sm"> NEXT <i class="fa fa-forward"> &nbsp; </i></button>
</div>



<div id="ModelImport" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Import CSV File</h4>
      </div>
	     <form name="formImport" method="POST" enctype="multipart/form-data" action="<?php echo base_url('upload-client-csv-data') ?>">
     	 <div class="modal-body">
	       <div class="form-group">
		    <label for="email">Select File(.csv):</label>
		    <input type="file" accept=".csv" class="form-control" id="clientcsv" name="clientcsv">
		  </div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary">Import</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	      </div>
     </form>
    </div>

  </div>
</div>



</section>

<script type="text/javascript">
	
// $(document).ready(function(){
//   $("#myInput").on("keyup", function() {
//     var value = $(this).val().toLowerCase();
//     $("#myTable tr").filter(function() {
//       $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
//     });
//   });
// });



        // $("#search").keyup(function () {
        //     var value = this.value.toLowerCase().trim();
        //     $("table tbody tr").each(function (index) {
        //         if (!index) return;
        //         $(this).find("td").each(function () {
        //             var id = $(this).text().toLowerCase().trim();
        //             var not_found = (id.indexOf(value) == -1);
        //             $(this).closest('tr').toggle(!not_found);
        //             return not_found;
        //         });
        //     });
        // });

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
             
            
            var redirectUrl = '<?php echo base_url('all-client-management') ?>?search='+searchtext+"&page="+pageno;
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





