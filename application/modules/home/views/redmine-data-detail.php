

<?php 



$ticket_id = $_GET['ticket'];

$user_profie = user_profile($user_id);



$data = [];

$attachments = [];

$journals = [];



if(!empty($user_profie)){
 
	$service_url = "https://tickets.mostwantedmodels.com/issues/".$ticket_id.".json?include=attachments,journals";

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

	// echo '<pre>';
	// print_r($response);

	if(!empty($response['issue'])){

		$data = $response['issue'];

		$attachments = $response['issue']['attachments'];

		$journals = $response['issue']['journals'];

	}

}



?>

<!-- Start Dashboard -->

<style type="text/css">

	.Table > table > tbody > tr > td:last-child {

    text-align: left;

}

ul.journals{

	margin-bottom: 0px;

}

ul.journals li{

    border-bottom: 1px solid #ccc;

    padding-top: 5px;

    padding-bottom: 5px;

    list-style: square;

}

ul.journals li:last-child{

    border-bottom: none;

    padding-top: 5px;

    padding-bottom: 0px;

    list-style: square;

}

ul.journals li::marker {

	color: #c3083c;

}

.username{

	color: #e8452f;

	/*text-transform: uppercase;*/

}
.journals del{
	color: #666;
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



							<h4> Open Ticket Detail </h4>



						</div>



						<div class="Table">

							<table class="table table-striped table-condensed">

									<?php 

									if(!empty($data)){		

									// print_r($data['subject']);							 

									?>



									<tr> 

										<th>Subject</th>

										<td><?php echo $data['subject'] ?></td>

										 

									</tr>

									<tr> 

										<th>Project</th>

										<td><?php if(!empty($data['project'])){ echo $data['project']['name']; } ?></td>

										 

									</tr>

									<tr> 

										<th>Tracker</th>

										<td><?php if(!empty($data['tracker'])){ echo $data['tracker']['name']; } ?></td>

										 

									</tr>

									<tr> 

										<th>Status</th>

										<td><?php if(!empty($data['status'])){ echo $data['status']['name']; } ?></td>

										 

									</tr>

									<tr> 

										<th>Priority</th>

										<td><?php if(!empty($data['priority'])){ echo $data['priority']['name']; } ?></td>

										 

									</tr>

									<tr> 

										<th>author</th>

										<td><?php if(!empty($data['author'])){ echo $data['author']['name']; } ?></td>

									</tr>

									<tr> 

										<th>Assigned To</th>

										<td><?php if(!empty($data['assigned_to'])){ echo $data['assigned_to']['name']; } ?></td>

									</tr>



									<tr> 

										<th>Created Date</th>

										<td><?php echo date("d M, Y h:i A", strtotime($data['created_on']));  ?></td>

									</tr>

 

									<?php

									}									 

									?>



									<!-- attachments -->



									<?php 

									 

									if(!empty($attachments)){

									?>

									<tr><td colspan="2" style="background-color: #000; color: #fff;">Attachments</td></tr>

									<tr>

										<th> Attachment File </th>

										<th> Description </th>



									</tr>

									<?php

										$filearray = array(

											'application/pdf' => 'fa fa-file-pdf-o', 

											'image/jpeg' => 'fa fa-file-image-o', 

											'image/jpg' => 'fa fa-file-image-o', 

											'image/png' => 'fa fa-file-image-o', 

											'image/gif' => 'fa fa-file-image-o', 

											'image/svg' => 'fa fa-file-image-o', 

											'image/webp' =>'fa fa-file-image-o'

										);



										foreach ($attachments as $attachment) {

											// print_r($attachment);

									?>



									<tr>

										<td>

											<div title="click to view">

												<a target="_blank" href="<?php echo $attachment['content_url']; ?>">

													 

													<i style="font-size: 40px; color: #c70303;"  class="<?php echo $filearray[strtolower($attachment['content_type'])] ?>" aria-hidden="true"></i> 

													<div><?php echo $attachment['filename']; ?></div>

												</a>

											</div>

										</td>

										<td><?php echo $attachment['description']; ?></td>

									</tr>

									<?php

										}

									}

									else{

									?>

									<tr>

										<td colspan="2"> <div class="alert alert-danger">No attachment(s) found.</div></td>

										 

									</tr>

									<?php

									}

									?>



									<?php 

									
									$assignee_users = get_issue_type();
									$issue_status = get_issue_status(); 

									if(!empty($journals)){

									?>

									<tr><td colspan="2" style="background-color: #000; color: #fff;">Journals</td></tr>

									<!-- <tr>

										<th> Journals </th>

									 

									</tr> -->

									<?php

										foreach ($journals as $journal) {
											// print_r($attachment);
									?>
									<tr>

										<td colspan="2">
											<div style="margin-top: 10px; color: #169; "><b> Updated by <?php echo $journal['user']['name'];
												$date1 = $journal['created_on'];
												$date2 = date('Y-m-d H:i:s');
												echo ' '.date_interval($date1, $date2); ?> ago</b>
											</div>

											<div class="property">
												<ul class="journals">
												 	<?php 

												 	if(!empty($journal['details'])){
												 		foreach ($journal['details'] as $detail) {
												 			if($detail['property'] == 'attachment'){
												 	?>
												 				<li>
												 					<?php 
												 					if(!empty($detail['new_value'])){
												 						echo '<b>File : </b>'.$detail['new_value'].' added';
												 					}
												 					if(!empty($detail['old_value'])){
												 						echo '<b>File : </b> <del> Deleted ('.$detail['old_value'].')</del>';
												 					}
												 					?>
												 				</li>
												 	<?php
												 			}
												 			if($detail['property'] == 'attr' && $detail['name'] == 'assigned_to_id' ){
												 	?> 
												 				<li>
												 					<?php 
												 					echo '<b>Assignee : </b>';
												 					if(!empty($detail['old_value'])){

												 						echo ' changed from '.$assignee_users[$detail['old_value']]; 
												 					}
												 					else{
												 						echo 'Assign ';
												 					} 
												 					echo ' to '.$assignee_users[$detail['new_value']];
												 					 
												 					?>
												 				</li>
												 	<?php
												 			}
												 			if($detail['property'] == 'attr' && $detail['name'] == 'status_id' ){
												 	?>
												 				<li>
												 					<?php 
												 					echo '<b>Status : </b> changed from '.$issue_status[$detail['old_value']].' to '.$issue_status[$detail['new_value']];				 
												 					?>
												 				</li>
												 	<?php
												 			}
												 	?> 
												 	<?php

												 		}

												 	}

												 	?>

												 </ul>
											</div>





											<div class="journalNotes"> <?php echo $journal['notes']; ?> </div>
												
										</td>

										 

									</tr>

									<?php

										}

									}

									else{

									?>

									<tr >

										<td colspan="2"> <div class="alert alert-danger">No journal(s) history found.</div></td>

										 

									</tr>

									<?php

									}

									?> 

							</table>



						</div>



					</div>





				</div>



			</div>



		</div>



	</div>



</section>
<script type="text/javascript">
	$(function(){
		$("table tr td div.journalNotes").filter(function(){
		    var html = $(this).html();
		    var emailPattern = /[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/;  

		    var matched_str = $(this).html().match(emailPattern);
		    if(matched_str){
			$(this).html(html.replace(emailPattern,"<a style='color: #169;font-weight: bold;' href='mailto:"+matched_str+"'>"+matched_str+"</a>"));
			return $(this)
		    }    
		})
	})
</script>


<!-- End Dashboard -->







