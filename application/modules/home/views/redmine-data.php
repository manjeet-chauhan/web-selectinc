<?php 
// $user_session = $this->session->userdata('user');
$user_profie = user_profile($user_id);
// print_r($user_profie);
$issues = [];
$records = 0;
$offset = 0;

$page = 0;
if (!empty($_GET['page'])) {
	$page = $_GET['page'];
	$offset = $page * 50;
}

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

	$service_url = "https://tickets.mostwantedmodels.com/projects/jobs/issues.json?offset=".$offset."&limit=50".$filter_data;
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

	// print_r($response);

	if(!empty($response['issues'])){
		$issues = $response['issues'];
		$records = $response['total_count'];
	}
} 

// print_r($issues);
?>

<!-- Start Dashboard -->


<style type="text/css">
	#form_filter div small b{
		color: #169;
		margin-bottom: 8px;
		/*font-weight: bold;
		border-bottom: 1px dotted #169;*/
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
							<h4> Open Ticket  List </h4>
						</div>

						<form id="form_filter">
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
										<th></th>
										<th>Sr.</th>
										<th>Project</th>
										<th>Status</th>
										<th>Subject</th>
										<th>Priority</th>
										<th>Assigned </th>
										<!-- <th>Author</th> -->
										<th>View</th>
									</tr>

								</thead>

								<tbody>

									<?php 

									if(!empty($issues)){
										$count = $offset;
										foreach ($issues as $data) {
									?>

									<tr>
										<td>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
												<label class="custom-control-label" for="customCheck"></label>
											</div>
										</td>



										<td><?php echo ++$count; ?></td>
										<td><?php echo $data['project']['name'] ?></td>
										<td><?php echo $data['status']['name'] ?></td>
										<td><?php echo $data['subject'] ?></td>
										<td><?php echo $data['priority']['name'] ?></td>
										<!-- <td><?php echo $data['author']['name'] ?></td> -->
										<td><?php if(!empty($data['assigned_to'])) echo $data['assigned_to']['name'] ?></td>
										<td><a class="btn btn-sm btn-info" href="<?php echo base_url('view-issues-issues-detail?ticket=').$data['id'] ?>">VIEW</a></td>
									</tr>
									<?php
										}
									}
									?>

									<tr>
										<td colspan="5"> Total <?php echo $records ?> Records</td>
										<?php 	

										$backdisabled = '';
										$nextdisabled = '';										

										$page_prev = 0;
										$page_next = 0; 

										if(count($issues) < 50){
											$nextdisabled = 'disabled';
										}

										else{
											$page_next = $page + 1;
										} 

										if($page <= 0){
											$page == 0;
											$backdisabled = 'disabled';
										}

										else{
											$page_prev = $page - 1;
										}
 
										$prev_url = base_url('view-issues-issues/?page=').$page_prev;
										$next_url = base_url('view-issues-issues/?page=').$page_next;
										?>

										<td colspan="3"> 

											<button  class="btn btn-sm btn-primary" <?php echo $backdisabled; ?> onclick="window.location.href='<?php echo $prev_url;  ?>'"> << Prev</button> &nbsp;&nbsp; 

											<button class="btn btn-sm btn-primary" <?php echo $nextdisabled; ?> onclick="window.location.href='<?php echo $next_url;  ?>'">Next >></button> 
										</td>
									</tr>
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







