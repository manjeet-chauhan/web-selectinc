<?php 
$sessionprofile = $this->session->userdata('user');
$profile = [];
if(!empty($sessionprofile)){
	 
	$user_access = get_user_access($sessionprofile->redmine_assignee);
	// print_r($user_access);
}

// $user_session = $this->session->userdata('user'); 

$user_profie = user_profile($user_id);
// print_r($user_profie);
$records = 0;
$issues = [];
$offset = 0;
$records_on_page = 25;

$filter_data = '';

$search_status = '';
if (!empty($_GET['status_id'])) {
	$search_status = $_GET['status_id'];
	$filter_data .= '&status_id='.$search_status;
}


$search_priority = ''; 
if (!empty($_GET['priority_id'])) {
	$search_priority = $_GET['priority_id'];
	$filter_data .= '&priority_id='.$search_priority;
}

$search_assignee = '';
if (!empty($_GET['assigned_to_id'])) {
	$search_assignee = $_GET['assigned_to_id'];
	$filter_data .= '&assigned_to_id='.$search_assignee;
}
else{
	$search_assignee = $user_profie->redmine_assignee;
	$filter_data .= '&assigned_to_id='.$search_assignee;
} 

if(!empty($user_profie)){
 
	$service_url = "https://tickets.mostwantedmodels.com/projects/jobs/issues.json?records=0".$filter_data;
	$curl = curl_init($service_url);
	$autho = $user_profie->redmine_username.':'.$user_profie->redmine_password;
	$request_headers = array(
		"Authorization:Basic ".base64_encode($autho),
	);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
	$curl_response = curl_exec($curl);
	curl_close($curl);
	$response = json_decode($curl_response, true);
	if(!empty($response['issues'])){
		$issues = $response['issues'];
		$records = $response['total_count'];
	}
}

$filter_data1 = '&status_id=10&limit=8';
$service_url = "https://tickets.mostwantedmodels.com/projects/jobs/issues.json?records=0".$filter_data1;
$curl = curl_init($service_url);
$autho = $user_profie->redmine_username.':'.$user_profie->redmine_password;
$request_headers = array(
	"Authorization:Basic ".base64_encode($autho),
);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
$curl_response = curl_exec($curl);
curl_close($curl);
$response_status = json_decode($curl_response, true);
// if(!empty($response['issues'])){
// 	$issues = $response['issues'];
// 	$records = $response['total_count'];
// }




// print_r($response_status);

?>

<!-- Start Dashboard -->

<style type="text/css">
	.Invoice.Box p a{
		color: #000;
	}
	.Invoice.Box p a span{
		 
		font-weight: bold;
	}

	#form_filter div small b{
		color: #169;
		margin-bottom: 8px;
		/*font-weight: bold;
		border-bottom: 1px dotted #169;*/
	}

	.table td, .table th {
     
    padding: 5px 5px;
}
</style>

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
							<h4>My Open Ticket List <a href="<?php echo base_url('view-issues-issues'); ?>"><button type="button" class="btn btn-primary">Show More</button></a></h4>
						</div>

						<form id="form_filter">

								<input type="hidden" name="offset" id="offset" value="<?php echo $offset ?>">
								<input type="hidden" name="limit" id="limit" value="<?php echo $records_on_page ?>">

								<div class="row">
									<div class="col-md-3">
										<div><small><b> Status Filter </b></small></div>
										<select id="status_id" name="status_id" class="form-control myselect">
											<option value="" disabled selected>Select Status Filter</option> 
											<?php 
											$s_status = get_issue_status();
											if(!empty($s_status)){
												foreach ($s_status as $key => $value) {
													$selected = '';
													if($key == $search_status){
														$selected = 'selected';
													}
													?>
													<option <?php echo $selected; ?> value="<?php echo $key ?>"  ><?php echo $value; ?></option>
													<?php
												}
											}
											?>  
										</select>
									</div>

									<div class="col-md-3">									 
										<div><small><b> Assignee Filter </b></small></div>
										<select id="assigned_to_id" name="assigned_to_id" class="form-control myselect">
											<option value="" disabled selected>Select Assignee Filter</option>
											<?php 
											$s_assignee = get_issue_type();
											if(!empty($s_assignee)){
												foreach ($s_assignee as $key => $value) {
													$selected = '';
													if($key == $search_assignee){
														$selected = 'selected';
													}

													?>
													<option <?php echo $selected; ?> value="<?php echo $key ?>"  ><?php echo $value; ?></option>
													<?php
												}
											}
											?>

										</select>
									</div>

									<div class="col-md-3">
										<div><small><b> Priority Filter </b></small></div>
										<select id="priority_id" name="priority_id" class="form-control myselect">
											<option value="" disabled selected>Select Priority Filter</option>
											<?php 
											$s_priority = get_issue_priority();
											if(!empty($s_priority)){
												foreach ($s_priority as $key => $value) {
													$selected = '';
													if($key == $search_priority){
														$selected = 'selected';
													}

													?>
													<option <?php echo $selected; ?> value="<?php echo $key ?>"  ><?php echo $value; ?></option>
													<?php
												}
											}
											?>

										</select>
									</div>

									<div class="col-md-3">
										<div><small><b> &nbsp; </b></small></div>
										<button type="submit" class="btn btn-info  ">Apply Filter</button>
									</div>
								</div>
							</form>

						<div class="Table">
							<table class="table table-striped">
								<thead>
									<tr>
										<!-- <th></th> -->
										<th>Sr.</th>
										<!-- <th>Project</th> -->
										<th>Status</th>
										<th>Subject</th>
										<th>Priority</th>
										<th>Assigned </th>
										<!-- <th>Author</th> -->								
										<!-- <th>View</th> -->
									</tr>
								</thead>
								<tbody>

									<?php 
									if(!empty($issues)){
										$i = 0;
										foreach ($issues as $data) {
									?>

									<tr onclick="window.location.href='<?php echo base_url('view-issues-issues-detail?ticket=').$data['id'] ?>'">
										<!-- <td>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
												<label class="custom-control-label" for="customCheck"></label>
											</div>

										</td> -->
										
										<td><?php echo ++$i; ?></td>
										<!-- <td><?php echo $data['project']['name'] ?></td> -->
										<td><?php echo $data['status']['name'] ?></td>
										<td><?php echo $data['subject'] ?></td>
										<td><?php echo $data['priority']['name'] ?></td>
										<td><?php if(!empty($data['assigned_to'])) echo $data['assigned_to']['name'] ?></td>
										<!-- <td><?php echo $data['author']['name'] ?></td> -->
										<!-- <td><a style="padding: 0px 10px;" class="btn btn-sm btn-info" href="<?php echo base_url('view-issues-issues-detail?ticket=').$data['id'] ?>"><i class="fa fa-eye"></i></a></td> -->
									</tr>
									<?php
										}
									}
									?>

									<tr>
										<td colspan="8"> Total <?php echo $records ?> Records</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<?php 
					if ($user_access->access == 2 || $user_access->access == 4) {
						exit();
					}
					?>
 
					<div class="SmallBox">
						<div class="row">

							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6> Draft Invoice </h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($draft_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('draft-invoice') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>

							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Open Invoice (Send)</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($open_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('open-invoice') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>

							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6> Approved Invoice </h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($approve_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('approve-invoice') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>



							<div class="col-lg-4 col-md-2">

								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Reminders</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>

									<?php 
									foreach ($reminder_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?> 
									<hr /> 
									<a href="<?php echo base_url('reminder-invoice') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>
							</div>


							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6> Payed Invoices Ready For Refund  </h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($payed_refund_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('payed-invoices-ready-for-refund') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>




							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6> Approved Invoice Ready for Email Send </h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($approve_invoices_email as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('approve-invoices-ready-for-email-send') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>




							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box Refund">
									<div class="BoxHeading">
										<h6>Refund Prepared</h6>
										<!-- <h5> &nbsp;	</h5> -->
									</div>


									<?php 
									foreach ($refund_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?> 
									 <hr>
									<a href="<?php echo base_url('refund-invoice') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  

								</div>
							</div> 


							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box Refund">
									<div class="BoxHeading">
										<h6>Payed Refund</h6>
										<!-- <h5> &nbsp;	</h5> -->
									</div>


									<?php 
									foreach ($payed_refund as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?> 
									 <hr>

									 
									<a href="<?php echo base_url('payed-refund') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  

								</div>
							</div> 



							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box Refund">
									<div class="BoxHeading">
										<h6>Select Expenses Overview</h6>
										<!-- <h5> &nbsp;	</h5> -->
									</div>


									<?php 
									foreach ($seLect_expenses as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?> 
									 <hr>
									<a href="<?php echo base_url('select-expenses-invoice') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  

								</div>
							</div> 



							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box Refund">
									<div class="BoxHeading">
										<h6>Payed To Models Overview</h6>
										<!-- <h5> &nbsp;	</h5> -->
									</div>


									<?php 
									foreach ($payed_model_overview as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?> 
									 <hr>

									 
									<a href="<?php echo base_url('payed-models-overview') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  

								</div>
							</div> 


							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box Refund">
									<div class="BoxHeading">
										<h6> Tickets on hold </h6>
										<!-- <h5> &nbsp;	</h5> -->
									</div>


									<?php 
									if(!empty($response_status)){

									 	$tickets = $response_status['issues'];
										foreach ($tickets as $invoice) {
											// $invoice->issue_id . 
											$detail_url = base_url('view-issues-issues-detail?ticket=').$invoice['id'];
										?>
										<p>
											<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
											<a href="<?php echo $detail_url; ?>"><?php echo "TICKET : <span>" . $invoice['id'].'</span> - '. $invoice['status']['name']; ?></a> 
										</p>
										<?php
										}
									}
									?> 
									 <hr>
									
									<a href="<?php echo base_url('hold-tickets/?status_id=10') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  

								</div>
							</div> 


							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- 
<div>
	<form id="formTestRemineUpdate" name="formTestRemineUpdate">
		<div>
			<div>Marcel Kötter for Trigema 30.03.2021</div>
			<div>4</div>
			<div>Title</div>
			<input type="text" name="txtsubject" id="txtsubject" >
			<input type="text" name="ticketid" id="ticketid" placeholder="ticket id">
		</div>
		<div>
			<div>Status</div>
			<input type="text" name="status" id="status" value="4">			 
		</div>
		<div>
			<button type="submit">Submit</button>
		</div>
	</form>
</div> -->

<script type="text/javascript">
	
	$(function(){
		$('#formTestRemineUpdate').submit(function(e){

			e.preventDefault();
			var ticketId = $('#ticketid').val();
			var newStatus = $('#status').val();

			jQuery.ajax({
		        type: "PUT",
		        url: "https://tickets.mostwantedmodels.com/projects/jobs/issues/"+ticketId+".json",
		        username: "assistant",
		        password: "Redmine99",
		        async: false,
		        contentType: "text/json", 
		        data: '{"issue": { "id":" "status": { "id": "1", "name": "This change is ignored" }  } ", "subject": "Sebastian Niedermaier für VRONIKAA 04.03.2021 manjeettt"}',

		        // { issue: { status_id : 4  } }, v  "status": { "id": "1", "name": "This change is ignored" }  } 
		        success: function(msg) { 
		        	console.log(msg);
		            alert("success");
		        },
		        // error: function(xhr, msg, error) {
			       //  alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
			       //  alert("responseText: "+xhr.responseText);
		        // }
		    });
		})
	})

</script>

<!-- End Dashboard -->







