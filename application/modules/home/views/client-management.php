

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

							<h4>Recent Contact Client</h4>

						</div>

						<div class="Table">

							<table class="table table-striped">

								<thead>

									<tr>

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

									$count_row = 0;

									if(!empty($client_mgmt)){

										foreach ($client_mgmt as $client) {

											$redirect_edit = base_url('edit-client-management/').$client->unique_code;

											$redirect_view = base_url('client-management-detail/').$client->unique_code;

									?>

									<tr onclick="window.location.href='<?php echo $redirect_edit; ?>'">

										<td><?php echo $client->company_name ?></td>

										<td><?php echo $client->name ?> </td>

										<td><?php echo $client->address_line1 ?></td>

										<td><?php echo $client->client_fee ?>%</td>

										<!-- <td><a href="<?php echo $redirect_view; ?>"><button type="button" class="btn"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a></td> -->

										<!-- <td><a href="<?php echo $redirect_edit; ?>"><button type="button" class="btn"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></a></td> -->

									</tr>



									<?php

											++$count_row;

											if($count_row == 10){

												break;

											}

										}

									}

									?>



								</tbody>

							</table>

						</div>

					</div>

					<div class="OpenTicket Box">

						<div class="BoxHeading">

							<h4>Client Management </h4>

						</div>

						<!-- <div class="ClientManagement">

							<a href="<?php echo base_url('all-client-management'); ?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/teamwork.svg'); ?>" alt="Icon"> All Clients</button></a>

							<button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/funnel.svg'); ?>" alt="Icon"> Search / Filter</button>



							<a href="<?php echo base_url('add-client-management'); ?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/contact.svg'); ?>" alt="Icon"> Add Client</button></a>



							<button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/import.svg'); ?>" alt="Icon"> Import Client</button>

						</div> -->

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

							<table class="table table-striped">

								<thead>

									<tr>

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

									if(!empty($client_mgmt)){

										foreach ($client_mgmt as $client) {

											$redirect_view = base_url('client-management-detail/').$client->unique_code;

											$redirect_edit = base_url('edit-client-management/').$client->unique_code;

									?>

									<tr onclick="window.location.href='<?php echo $redirect_edit; ?>'">

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

</section>

<!-- End Dashboard -->

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


<script type="text/javascript">
	  // $("#search").keyup(function () {
   //          var value = this.value.toLowerCase().trim();
   //          $("table tbody tr").each(function (index) {
   //              if (!index) return;
   //              $(this).find("td").each(function () {
   //                  var id = $(this).text().toLowerCase().trim();
   //                  var not_found = (id.indexOf(value) == -1);
   //                  $(this).closest('tr').toggle(!not_found);
   //                  return not_found;
   //              });
   //          });
   //      });

</script>


