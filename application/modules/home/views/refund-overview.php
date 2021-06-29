

	<!-- Reports overview Start -->

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
							<h4>Refunds Models<a href="<?php echo base_url('edit-refund-invoice'); ?>"><button type="button" class="btn btn-primary"> + Create Refund</button></a></h4>
							<h5>€ 5680,90 </h5>
							<p>open/not payed yet to the model </p>
						</div>
					</div>


					<div class="SmallBox">

						<div class="row">

							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6> Draft Refund </h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($draft_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-refund-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('draft-refund') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>

							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Open Refund (Send)</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($open_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-refund-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('open-refund') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>

							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6> Approved Refund </h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($approve_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-refund-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('approve-refund') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>



							<div class="col-lg-4 col-md-2" style="display: none;">

								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Reminders</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>

									<?php 
									foreach ($reminder_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-refund-details/').$invoice->invoice_number;
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
										$detail_url = base_url('invoive-refund-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?> 
									 <hr>
									<a href="<?php echo base_url('prepared-refund') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  

								</div>
							</div>

						</div>

					</div><div class="OpenTicket Box NoRadius">

						<div class="BoxHeading">

							<h4>Overview all Refunds</h4>

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

										<th>Invoice</th>
										<th>Edit</th>

									</tr>

								</thead>

								<tbody>

									<?php

									// deduction-lists.php

									foreach ($invoices as $invoice) {
										$invoice_url = base_url('invoive-refund-details/').$invoice->invoice_number;
										$edit_url = base_url('edit-refund-invoice?invoive=').$invoice->invoice_number; 
									?>

									<tr>
										<td><?= $invoice->creation_date?> </td>
										<td><?= $invoice->job_date ?> </td>
										<td><?= $invoice->invoice_number?> </td>
										<td><?= $invoice->i_company_name?> </td>
										<td><?= $invoice->m_model_name?> </td>
										<td><?= $invoice->model_budget?> </td>
										<td><?= $invoice->model_total_agreed?> </td>
										<td><?= $invoice->m_vat_percent?>% </td>
										<td><?= $invoice->modelExp?> </td>
										<td><?= $invoice->model_agency_comission?>% </td>
										<td><?= $invoice->vat_price?>% </td>
										<td><?php echo $invoice->selectInc; ?></td>
										<td><?=  ($invoice->model_total_agreed + $invoice->vat_price + $invoice->selectInc) ?></td>
										<td><a href="<?php echo $invoice_url; ?>" class="btn btn-sm btn-primary" >INVOICE</a></td>
										<td>
											<?php 
											if($invoice->approve == 0){
											?>
											<a href="<?php echo $edit_url; ?>" class="btn btn-sm btn-primary btn-block">EDIT</a>
											<?
											}
											else if($invoice->approve == 1){
											?>
											<a href="javascript:void(0)" class="btn btn-sm btn-success btn-block">APPROVED</a>
											<?
											}
											else if($invoice->approve == 2){
											?>
											<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-block">SENT FOR APPROVAL</a>
											<?
											}
											?>
										</td>

									</tr>

									<?php

								}

									?>

									<!-- <tr>

										<td>

									<?php print_r($invoices);?>

								</td></tr> -->

								</tbody>

							</table>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<!-- Reports overview End -->

