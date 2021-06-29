<style type="text/css">

	.Overview a.btn{

		color: #fff !important;

	}

.table td, .table th {
    /* padding: .75rem; */
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
    padding: 5px;
    cursor: pointer;
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

							<h4>Accepted Invoice <a href="<?php echo base_url('generate-new-invoice') ?>"><button type="button" class="btn btn-primary">Generate New Invoices</button></a></h4>

							<h5>98460,23</h5>

							<p>Open</p>

						</div>

					</div>

					
					<div class="OpenTicket Box">

						<div class="BoxHeading">

							<h4>Overview all Accepted Invoices</h4>

						</div>

						<div class="filterControls">
						 		
							<form id="formFilter" name="formFilter">  
							    <div class="row">
							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<label for="pwd">Months:</label>
								    		<select name="month" id="month" class="form-control">
								    			<option value="" selected>Select Month</option>
								    			<?php 
								    			$months = get_months();
								    			if(!empty($months)){
								    				foreach ($months as $key => $value) {
								    					$selected = '';
								    					if(!empty($month)){
								    						if($month == $key)
								    							$selected = 'selected';
								    					}
								    			?>
								    			<option <?php echo $selected; ?> value="<?php echo $key ?>" ><?php echo $value; ?></option>
								    			<?php
								    				}
								    			}
								    			?>
								    		</select>
								    	</div>
							    	</div>

							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<label for="pwd">Years:</label>
								    		<select name="year" id="year" class="form-control">
								    			<option value="" selected>Select Year</option>
								    			<?php 
								    			$years = get_years();
								    			if(!empty($years)){
								    				foreach ($years as $value) {
								    					$selected = '';
								    					if(!empty($year)){
								    						if($year == $value)
								    							$selected = 'selected';
								    					}
								    			?>
								    			<option <?php echo $selected; ?>  value="<?php echo $value ?>" ><?php echo $value; ?></option>
								    			<?php
								    				}
								    			}
								    			?>
								    		</select>
								    	</div>
							    	</div>

							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<label for="pwd">MWM Vat:</label>
								    		<select name="vat" id="vat" class="form-control">
								    			<option value="" selected>Select Vat</option>
								    			<?php 
								    			$mwm_vat = get_mwm_vat();
								    			if(!empty($mwm_vat)){
								    				foreach ($mwm_vat as $value) {
								    					$selected = '';
								    					if(!empty($mvat)){
								    						if($mvat == $value->vat_price)
								    						$selected = 'selected';
								    					}
								    			?>
								    			<option <?php echo $selected; ?>  value="<?php echo $value->vat_price ?>" ><?php echo $value->vat_price; ?></option>
								    			<?php
								    				}
								    			}
								    			?>
								    		</select>
								    	</div>
							    	</div>

							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<label for="pwd">Total Amount:</label>
								    		<input type="number" class="form-control" name="total_amount" id="total_amount" placeholder="5600" value="<?php echo $total_amount; ?>">
								    	</div>
							    	</div>

							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<label for="pwd">Others:</label>
								    		<input type="text" class="form-control" name="other" id="other" placeholder="search" value="<?php echo $other; ?> ">
								    	</div>
							    	</div>

							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<!-- <label for="pwd">.&nbsp;</label> -->
								    		<button style="margin-top: 34px;" type="submit" class="btn btn-primary btn-sm btn-block">Filter</button>
								    		<!-- <button style="margin-top: 34px;" type="button" class="btn btn-info btn-sm" onclick="$('#formFilter').attr('action', '<?php echo base_url('download-invoice-list-pdf'); ?>'); $('#formFilter').submit();"><i class="fa fa-download"></i> PDF</button> -->
								    	</div>
							    	</div>
							    </div>

							    </form>
								 
						 	</div>


						<div class="Table invoice Overview">

							<table class="table table-striped">

								<thead>

									<tr>
										<th>Email</th>
										<th>Date</th>
										<th>Job Date</th>
										<th>Invoice No.</th>
										<th>Client</th>
										<th>Model</th>
										<th>Amount Accepted</th>
										<th>Accepted Model</th>
										<th>VAT Model</th>
										<th>Expenses</th>
										<th>Agency Comission</th>
										<th>VAT (AC)</th>
										<th>Select </th>
										<th>Total</th>
										<th>View</th>
										<th>Edit</th>
									</tr>

								</thead>

								<tbody>

									<?php
									// print_r($invoices);

									foreach ($invoices as $invoice) { 

										$invoice_url = base_url('invoive-details/').$invoice->invoice_number;
										$edit_url = base_url('edit-invoive?invoive=').$invoice->invoice_number; 
										// $i_service = invoice_service

										$color = '';
										$bcolor = '';
										$checked = '';
										if($invoice->approve_email){
											$bcolor = '#67c367';
											$color = '#fff';
											$checked = 'checked';
										}
									?>

									<tr style="background-color: <?php echo $bcolor ?>; color: <?php echo $color ?>">

										<td>
											<label><input <?php echo $checked; ?> type="checkbox" name="chkEmail" onchange="markSendEmail(this, '<?php echo $invoice->invoice_number; ?>')">Mark</label>
										</td>
										<td><?= date('d-m-Y', strtotime($invoice->creation_date))?> </td>
										<td><?= date('d-m-Y', strtotime($invoice->job_date)) ?> </td>
										<td><?= $invoice->invoice_number?> </td>
										<td><?= $invoice->i_company_name?> </td>
										<td><?= $invoice->m_model_name?> </td>	
										<td><?= $invoice->model_budget?> </td>
										<td><?= $invoice->model_total_agreed?> </td>
										<td><?= $invoice->m_vat_percent?>% </td>
										<td><?= $invoice->modelExp?> </td>
										<td><?= $invoice->model_agency_comission?>% </td>
										<td><?= $invoice->vat_price?>% </td>
										<td><?= $invoice->selectInc?> </td>
										<td><?=  ($invoice->model_total_agreed + $invoice->vat_price + $invoice->selectInc) ?></td>

										<td><a href="<?php echo $invoice_url; ?>" class="btn btn-sm btn-primary" ><i class="fa fa-eye"></i></a></td>
										<td>
											<?php 
											if($invoice->approve == 0){
											?>
											<a title="Edit" href="<?php echo $edit_url; ?>" class="btn btn-sm btn-primary btn-block"><i class="fa fa-pencil-square-o"></i></a>
											<?
											}
											else if($invoice->approve == 1){
											?>
											<a title= "Approved" href="javascript:void(0)" class="btn btn-sm btn-success btn-block"><i class="fa fa-times-circle"></i></a>
											<?
											}
											else if($invoice->approve == 2){
											?>
											<a title= "Send for Approval" href="javascript:void(0)" class="btn btn-sm btn-danger btn-block"><i class="fa fa-check"></i></a>
											<?
											}
											?>
										</td>

									</tr>

									<?php

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


<!-- <div id="displaymsg"></div> -->

<script type="text/javascript">
	 
		function markSendEmail(thisObj, invoice){

			var r = confirm("Are you sure, you want to mark as approve sent email!");
			if (r == true) {

				var email_ckecked = 0;
				if($(thisObj).prop('checked') == true){
					email_ckecked = 1;
				}

				$('#displaymsg').removeClass(' alert alert-info');
				$('#displaymsg').removeClass(' alert alert-success');
				$('#displaymsg').removeClass(' alert alert-danger');

				$('#displaymsg').html('Please wait');
				$('#displaymsg').show().delay(5000).fadeOut();
				$('#displaymsg').addClass(' alert alert-info'); 

				$.ajax({

					url: '<?php echo base_url('save-accepted-invoice-email-send'); ?>',
					type: "POST",
					data: {
						email_ckecked : email_ckecked,
						invoice_no : invoice
					},
					success: function (data) {
						$('#displaymsg').removeClass(' alert alert-info');
						if(data == "success"){

							var showtext = 'Unmark for approved email sent successfully';
							if(email_ckecked == 1){
								showtext = 'Mark for approved email sent successfully';
							}

							$('#displaymsg').html(showtext);
							$('#displaymsg').show().delay(5000).fadeOut();
							$('#displaymsg').addClass(' alert alert-success');
	            			location.reload();
	            			return true; 
	            		} 
	            		if(data == "error"){
	            			$('#displaymsg').html('Error to mark/unmark to send approved email., retry');
	            			$('#displaymsg').show().delay(5000).fadeOut();
	            			$('#displaymsg').addClass(' alert alert-danger');
	            			return false;
	            		}

	            		$('#displaymsg').html(data);
	            		$('#displaymsg').show().delay(5000).fadeOut();
	            		$('#displaymsg').addClass(' alert alert-danger');
	            	}
	        	});
			}
		}
 </script>

<!-- End Dashboard -->





