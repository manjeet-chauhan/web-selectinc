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
<style type="text/css">
	.invccont{
		 
        position: absolute;
    right: 52px;
    padding: 10px;
    z-index: 9;
	}
	.invoicecont, .reversechrg{
		margin-bottom: 5px;
	}
	.invoicecont button, .reversechrg button{
		width: 100%;
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

						<div class="invccont">
							<div class="invoicecont"><a href="<?php echo base_url('generate-new-invoice') ?>"><button type="button" class="btn btn-primary">Generate New Invoices</button></a> </div>
							<div class="reversechrg">
								<a href="<?php echo base_url('generate-reverse-charge-invoice') ?>"><button type="button" class="btn btn-primary">Reverse Charges Invoices</button></a>
							</div>
						</div>

						<div class="BoxHeading">
							<h4> Invoice Overview </h4> 

							<h5>98460,23</h5>

							<p>Open</p>

						</div>

					</div>

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
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?> </a> 
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
										<h6>Partner Invoice</h6>
										<!-- <h5> &nbsp;	</h5> -->
									</div>


									<?php 
									foreach ($general_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('general-invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?> 
									 <hr>
									<a href="<?php echo base_url('general-invoices') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  

								</div>
							</div>


							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box Refund">
									<div class="BoxHeading">
										<h6>Approved Invoices Ready For Email Send</h6>
										<!-- <h5> &nbsp;	</h5> -->
									</div>


									<?php 
									foreach ($sent_email as $invoice) {
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
									<a href="<?php echo base_url('accepted-invoice') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  

								</div>
							</div>



						</div>

					</div>

					<div class="OpenTicket Box">

						<div class="BoxHeading">

							<h4>Overview all Invoices</h4>

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
								    		<button style="margin-top: 34px;" type="submit" class="btn btn-primary btn-sm">Filter</button>
								    		<button style="margin-top: 34px;" type="button" class="btn btn-info btn-sm" onclick="$('#formFilter').attr('action', '<?php echo base_url('download-invoice-list-pdf'); ?>'); $('#formFilter').submit();"><i class="fa fa-download"></i> PDF</button>
								    	</div>
							    	</div>
							    </div>

							    </form>
								 
						 	</div>


						<div class="Table invoice Overview">

							<table class="table table-striped">

								<thead>

									<tr>
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
									?>

									<tr>

										<td><?= date('d-m-Y', strtotime($invoice->creation_date))?> </td>
										<td><?= date('d-m-Y', strtotime($invoice->job_date)) ?> </td>
										<td><?= $invoice->invoice_number?> </td>
										<td><?= $invoice->i_company_name?> </td>
										<td><?= $invoice->m_model_name?> </td>	
										<td><?= $invoice->model_budget?> </td>
										<td><?= $invoice->model_total_agreed?> </td>
										<td><?= $invoice->m_vat_percent?>% </td>
										<td><?= number_format(floatval($invoice->modelExp), 2)  ?> </td>
										<td><?= $invoice->model_agency_comission?>% </td>
										<td><?= number_format(floatval($invoice->vat_price),2); ?>% </td>
										<td><?= number_format(floatval($invoice->selectInc),2); ?> </td>
										<td><?=  (floatval($invoice->model_total_agreed) + floatval($invoice->vat_price) + floatval($invoice->selectInc)) ?></td>

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

<!-- End Dashboard -->





